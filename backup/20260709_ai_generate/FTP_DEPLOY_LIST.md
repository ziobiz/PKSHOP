# FTP 배포 목록 — AI 여름상품 자동생성 (2026-07-09)

## 이번 작업 배포 파일 (신규)

| 로컬 경로 | 서버 업로드 경로 |
|-----------|------------------|
| `Adm/product/pro_ai_generate.php` | `/Adm/product/pro_ai_generate.php` |
| `Adm/product/pro_ai_generate_run.php` | `/Adm/product/pro_ai_generate_run.php` |
| `Adm/product/gemini_client.php` | `/Adm/product/gemini_client.php` |
| `Adm/product/pro_import_lib.php` | `/Adm/product/pro_import_lib.php` |
| `Adm/inc/left_menu_product.php` | `/Adm/inc/left_menu_product.php` |
| `lib/gemini_secrets.local.php` | `/lib/gemini_secrets.local.php` |

## 상품 일괄등록 (이전 작업, 미배포 시 함께)

| 로컬 경로 | 서버 업로드 경로 |
|-----------|------------------|
| `Adm/product/pro_import.php` | `/Adm/product/pro_import.php` |
| `Adm/product/pro_import_ok.php` | `/Adm/product/pro_import_ok.php` |
| `Adm/product/pro_import_template.php` | `/Adm/product/pro_import_template.php` |

## 서버에서 생성되는 폴더 (업로드 불필요)

- `Adm/product/ai_gen_cache/` — 작업 진행 캐시 (자동 생성)
- `upload/` — AI 생성 이미지 저장 (기존 폴더, 쓰기 권한 필요)

## 배포 후 확인

1. https://pentakleva.shop/Adm/login/login.php 관리자 로그인
2. 좌측 **AI 여름상품 생성** 메뉴 확인
3. 카테고리 선택 → **샘플 3개** 먼저 실행
4. 성공 후 **30개** 전체 생성
5. `/upload/` 에 이미지 파일 생성 확인
6. 전체상품관리·프론트 목록/상세 확인

## API 키

`lib/gemini_secrets.local.php` 에 제미나이 API 키 포함. **git에 커밋하지 마세요.**

## 예상 API 사용량

| 수량 | 이미지 | 텍스트 |
|------|--------|--------|
| 샘플 3개 | 12장 | 1회 기획 |
| 전체 30개 | 120장 | 1회 기획 |
