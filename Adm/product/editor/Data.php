<%@ Language=VBScript %> 
<% 
Response.Buffer = False 
filepath = Request.QueryString("filename") 
filename = Mid(filepath, InStrRev(filepath, "\")+1) 

Response.AddHeader "Content-Disposition","attachment;filename=" & filename 

set objFS =Server.CreateObject("Scripting.FileSystemObject") 
set objF = objFS.GetFile(filepath) 
Response.AddHeader "Content-Length", objF.Size 
set objF = nothing 
set objFS = nothing 

Response.ContentType = "application/unknown" 
Response.CacheControl = "public" 

Set objDownload = Server.CreateObject("DEXT.FileDownload") 
objDownload.Download filepath 
Set objDownload = Nothing 
%> 
