param(
    [Parameter(ValueFromRemainingArguments = $true)]
    [string[]]$Files
)

$ErrorActionPreference = "Stop"
$root = Split-Path -Parent (Split-Path -Parent $MyInvocation.MyCommand.Path)
$secretsPath = Join-Path $root "lib\deploy_secrets.local.ps1"

if (-not (Test-Path $secretsPath)) {
    Write-Error "Missing $secretsPath — copy lib/deploy_secrets.local.ps1.example and set FTP credentials."
}

. $secretsPath

if (-not $Files -or $Files.Count -eq 0) {
    Write-Error "Usage: deploy_ftp.ps1 <relative-path> [more paths...]"
}

function Ensure-FtpDir {
    param([string]$RemoteDir)
    $parts = $RemoteDir.Trim('/').Split('/')
    $current = ""
    foreach ($part in $parts) {
        if ($part -eq "") { continue }
        $current += "/$part"
        try {
            $req = [System.Net.FtpWebRequest]::Create("ftp://$DeployFtpHost$current")
            $req.Method = [System.Net.WebRequestMethods+Ftp]::MakeDirectory
            $req.Credentials = New-Object System.Net.NetworkCredential($DeployFtpUser, $DeployFtpPass)
            $req.UsePassive = $true
            $resp = $req.GetResponse()
            $resp.Close()
        } catch {}
    }
}

foreach ($rel in $Files) {
    $rel = $rel -replace '\\', '/'
    $local = Join-Path $root ($rel -replace '/', '\')
    if (-not (Test-Path $local)) {
        Write-Error "Local file not found: $rel"
    }

    $remote = "/" + $rel
    $remoteDir = (Split-Path $remote -Parent) -replace '\\', '/'
    if ($remoteDir -and $remoteDir -ne '/') {
        Ensure-FtpDir $remoteDir
    }

    $uri = "ftp://$DeployFtpHost$remote"
    $req = [System.Net.FtpWebRequest]::Create($uri)
    $req.Method = [System.Net.WebRequestMethods+Ftp]::UploadFile
    $req.Credentials = New-Object System.Net.NetworkCredential($DeployFtpUser, $DeployFtpPass)
    $req.UseBinary = $true
    $req.UsePassive = $true
    $bytes = [System.IO.File]::ReadAllBytes($local)
    $stream = $req.GetRequestStream()
    $stream.Write($bytes, 0, $bytes.Length)
    $stream.Close()
    $resp = $req.GetResponse()
    Write-Host "OK $remote - $($resp.StatusDescription)"
    $resp.Close()
}
