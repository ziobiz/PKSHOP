# 상품 일괄등록 백업 (2026-07-09)

## 추가된 파일

- `Adm/product/pro_import.php` — 업로드 UI
- `Adm/product/pro_import_ok.php` — 처리 및 결과
- `Adm/product/pro_import_lib.php` — 공통 로직 (pro_up_ok.php INSERT 패턴)
- `Adm/product/pro_import_template.php` — CSV/엑셀 샘플 템플릿

## 수정된 파일

- `Adm/inc/left_menu_product.php` — "상품 일괄등록" 메뉴 추가

## 롤백

1. `pro_import.php`, `pro_import_ok.php`, `pro_import_lib.php`, `pro_import_template.php` 삭제
2. `left_menu_product.php` 에서 일괄등록 메뉴 4줄 제거

## 참고

- 상품코드: pro_up.php 와 동일한 자동생성 로직
- DB INSERT: pro_up_ok.php 와 동일한 shop_goods 컬럼
- 이미지: 파일 업로드 없음 — /upload/ 기존 파일명만 참조
