# AI 여름상품 자동생성 (2026-07-09)

제미나이(Gemini) API로 상품 기획·이미지·DB 등록을 자동화합니다.

## 파일

| 파일 | 역할 |
|------|------|
| `lib/gemini_secrets.local.php` | API 키 (git 제외) |
| `Adm/product/gemini_client.php` | Gemini 텍스트·이미지 API |
| `Adm/product/pro_ai_generate.php` | 관리자 UI |
| `Adm/product/pro_ai_generate_run.php` | AJAX 배치 처리 |
| `pro_import_lib.php` | `pkshop_ai_insert_product()` 추가 |

## 사용법

1. FTP로 파일 배포 + `lib/gemini_secrets.local.php` 업로드
2. 관리자 → **AI 여름상품 생성**
3. 카테고리 선택 → 샘플 3개 → 성공 시 30개

## 이미지 매핑

| 슬롯 | 용도 |
|------|------|
| imgl | 카탈로그 플랫레이 |
| imgm | 모델 착용 메인 |
| imgb1 | 소재 디테일 |
| imgb2 | 스타일링 추가 |
