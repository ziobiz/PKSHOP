# FTP 배포 목록 — 상품 일괄등록 (2026-07-09)

호스트: pentakleva.shop  
FTP ID: linemdjp / 포트: 21

## 이번 작업 배포 파일 (신규)

| 로컬 경로 | 서버 업로드 경로 |
|-----------|------------------|
| `Adm/product/pro_import.php` | `/Adm/product/pro_import.php` |
| `Adm/product/pro_import_ok.php` | `/Adm/product/pro_import_ok.php` |
| `Adm/product/pro_import_lib.php` | `/Adm/product/pro_import_lib.php` |
| `Adm/product/pro_import_template.php` | `/Adm/product/pro_import_template.php` |
| `Adm/inc/left_menu_product.php` | `/Adm/inc/left_menu_product.php` |

## 이전 작업 배포 파일 (비회원 가격 공개 — commit 3453363)

이미 서버에 반영되었다면 재업로드 불필요. 미반영 시 함께 업로드:

| 로컬 경로 | 서버 업로드 경로 |
|-----------|------------------|
| `include/shop_public_config.php` | `/include/shop_public_config.php` |
| `include/get_balance.php` | `/include/get_balance.php` |
| `main/main.html` | `/main/main.html` |
| `sub04/list.php` | `/sub04/list.php` |
| `sub04/view.php` | `/sub04/view.php` |

## 배포 후 확인

1. 관리자 로그인: https://pentakleva.shop/Adm/login/login.php
2. 좌측 메뉴 **상품 일괄등록** 링크 확인
3. CSV/엑셀 템플릿 다운로드 → 샘플 1건 등록 테스트
4. 등록된 상품이 **전체상품관리**에 표시되는지 확인
5. 프론트 상품목록/상세에서 비회원 가격 노출 확인 (이전 작업)

## 사용 방법

1. **분류등록/수정** 메뉴에서 카테고리 code1~code4 확인
2. **상품 일괄등록** → 템플릿 다운로드
3. 엑셀에서 상품 데이터 입력 (헤더 행 유지)
4. CSV 또는 XLS로 저장 후 업로드
5. 결과 화면에서 성공/실패 건수 확인

## 이미지 일괄등록 시

이미지 파일은 FTP로 `/upload/` 폴더에 먼저 업로드한 뒤,
템플릿의 `리스트이미지`, `중간이미지`, `상세이미지1` 컬럼에 파일명을 입력합니다.

## 롤백

- 일괄등록 기능 제거: `pro_import*.php` 4개 삭제 + `left_menu_product.php` 원복
- 비회원 가격 비공개: `backup/20260709_price_login_gate/README.md` 참고
