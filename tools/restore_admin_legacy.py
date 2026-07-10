#!/usr/bin/env python3
"""Restore PKSHOP Adm pages from admin_shell back to legacy top_menu layout."""
import os
import re
import subprocess

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
ADM = os.path.join(ROOT, "Adm")


def git_show(commit, path):
    try:
        out = subprocess.check_output(
            ["git", "-C", ROOT, "show", f"{commit}:{path}"],
            stderr=subprocess.DEVNULL,
        )
        return out.decode("utf-8", errors="replace")
    except subprocess.CalledProcessError:
        return None


def infer_menu_block(rel):
    if "/product/" in rel.replace("\\", "/"):
        name = os.path.basename(rel)
        if "pro_order" in name or name.startswith("order_") and "order_day" not in name and "order_month" not in name:
            left = "left_menu_order.php"
        elif any(x in name for x in ("order_day", "order_month", "buyer_info", "offer", "master_")):
            left = "left_menu_sell.php"
        else:
            left = "left_menu_product.php"
        return f'include "../inc/top_menu.php";\ninclude "../inc/{left}";\n\n'
    if "/member/" in rel.replace("\\", "/"):
        return 'include "../inc/top_menu.php";\ninclude "../inc/left_menu_member.php";\n\n'
    if "/admin_pass/" in rel.replace("\\", "/"):
        return '<? include "../inc/top_menu.php"; \n\n'
    if "/center/" in rel.replace("\\", "/"):
        return 'include "../inc/top_menu.php";\ninclude "../inc/left_menu_center.php";\n\n'
    if "/db_table/" in rel.replace("\\", "/"):
        return 'include "../inc/top_menu.php";\ninclude "../inc/left_menu_db_table.php";\n\n'
    if "/main/" in rel.replace("\\", "/"):
        return 'include "../inc/top_menu.php";\ninclude "../inc/left_menu_main.php";\n\n'
    return 'include "../inc/top_menu.php";\n\n'


def extract_menu_block(old):
    if not old:
        return None
    patterns = [
        r'include\s+["\']\.\./inc/top_menu\.php["\'];\s*\n(?:include\s+["\']\.\./inc/left_menu[^"\']+["\'];\s*\n)?',
        r'<\?\s*include\s+["\']\.\./inc/top_menu\.php["\'];\s*\n',
    ]
    for pat in patterns:
        m = re.search(pat, old)
        if m:
            return m.group(0).rstrip() + "\n\n"
    return None


def strip_shell(content):
    content = re.sub(
        r'(?m)^\s*include_once\s+["\']\.\./inc/admin_shell_lib\.php["\'];\s*\r?\n',
        "",
        content,
    )
    content = re.sub(
        r'(?m)^\s*<\?php\s+pkshop_admin_auto_shell_begin\(\);\s*\?>\s*\r?\n',
        "",
        content,
    )
    content = re.sub(
        r'(?m)^\s*pkshop_admin_auto_shell_begin\(\);\s*\r?\n',
        "",
        content,
    )
    content = re.sub(
        r'(?m)^\s*pkshop_admin_shell_begin\([^)]*\);\s*\r?\n',
        "",
        content,
    )
    content = re.sub(
        r'(?m)^\s*<\?php\s+pkshop_admin_shell_end\(\);\s*\?>\s*\r?\n',
        "",
        content,
    )
    content = re.sub(
        r'(?m)^\s*pkshop_admin_shell_end\(\);\s*\r?\n',
        "",
        content,
    )
    return content


def fix_file(rel):
    rel = rel.replace("\\", "/")
    path = os.path.join(ROOT, rel.replace("/", os.sep))
    if not os.path.isfile(path):
        return False

    with open(path, "r", encoding="utf-8", errors="replace") as fh:
        cur = fh.read()
    orig = cur
    cur = strip_shell(cur)

    old = git_show("3453363", rel)
    menu_block = extract_menu_block(old) or infer_menu_block(rel)

    if "top_menu.php" not in cur:
        if re.search(r'include\s+["\']\.\./common/dbconn\.php["\'];', cur):
            cur = re.sub(
                r'(include\s+["\']\.\./common/dbconn\.php["\'];\s*\r?\n)',
                r"\1" + menu_block,
                cur,
                count=1,
            )
        else:
            cur = re.sub(r"(<\?\s*\r?\n)", r"\1" + menu_block, cur, count=1)

    if old and "down_menu.php" in old and "down_menu.php" not in cur:
        cur = cur.rstrip() + '\n<? include "../inc/down_menu.php"; ?>\n'

    if cur != orig:
        with open(path, "w", encoding="utf-8", newline="\n") as fh:
            fh.write(cur)
        return True
    return False


def main():
    out = subprocess.check_output(
        ["git", "-C", ROOT, "grep", "-l", "admin_shell", "HEAD", "--", "Adm"],
        text=True,
        errors="replace",
    )
    files = []
    for line in out.strip().splitlines():
        if ":" in line:
            files.append(line.split(":", 1)[1].strip())

    fixed = []
    for rel in files:
        if fix_file(rel):
            fixed.append(rel)

    for rel in fixed:
        print(rel)
    print(f"FIXED {len(fixed)} files")


if __name__ == "__main__":
    main()
