# 가격 로그인 게이트 백업 (2026-07-09)

비회원 가격 공개 전 원본 파일입니다.

| 파일 | 설명 |
|------|------|
| login_check.php | 상품상세 등 회원 전용 차단 |
| get_balance.php | 잔액 API (비회원 미처리) |
| view.php | 상품상세 — login_check 포함 |
| list.php | 목록 — member_id 없으면 가격 숨김 |
| main.html | 메인 — member_id 없으면 가격 숨김 |

복구: `PKSHOP_PUBLIC_PRICE` 를 `false` 로 두거나, 이 폴더 파일로 덮어쓰기.
