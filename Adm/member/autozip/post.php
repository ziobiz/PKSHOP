<?
/*************************************************************************
 * 파일명 : post.php
 * 기  능 : 삼정데이타서비스(주) 주소 검색 웹서비스용 클라이언트 클래스
 * 작성일 : 2002-11-01
 * 작성자 : 황미영 (popoo@sds.co.kr)
 *************************************************************************/

//
// 우편번호 검색 클래스
//

class Post {

  var $service_server = "http://webservice.direct.co.kr/Post1.x/Post.asmx/";
  var $ErrMsg = "";

  ////////////////////////////////////////////////////////////////
  // '구/군'으로 주소 검색
  //
  // o 리턴값
  //
  // - False : 에러
  // - String : 서버 측으로부터 예외 메시지
  // - Array(2차원배열) : 주소 결과
  //   Array[n][0] => 우편번호, Array[n][1] => 주소
  ////////////////////////////////////////////////////////////////
  function GetGuGun($sido) {
    $xml_file = $this->service_server."GetGuGunToByte?Sido=".urlencode(trim($sido));
    return ( $this->parse_post($xml_file) );
  }

  ////////////////////////////////////////////////////////////////
  // '시/도'로 주소 검색
  //
  // o 리턴값
  //
  // - False : 에러
  // - String : 서버 측으로부터 예외 메시지
  // - Array(2차원배열) : 주소 결과
  //   Array[n][0] => 시/도
  ////////////////////////////////////////////////////////////////
  function GetSido() {
    $xml_file = $this->service_server."GetSidoToByte";
    return ( $this->parse_post($xml_file) );
  }

  ////////////////////////////////////////////////////////////////
  // '동'으로 주소 검색
  //
  // o 리턴값
  //
  // - False : 에러
  // - String : 서버 측으로부터 예외 메시지
  // - Array(2차원배열) : 주소 결과
  //   Array[n][0] => 우편번호, Array[n][1] => 주소
  ////////////////////////////////////////////////////////////////
  function GetPostByDong($dong) {
    $xml_file = $this->service_server."GetPostByDongToByte?Dong=".urlencode(trim($dong));

    return ( $this->parse_post($xml_file) );
  }

  ////////////////////////////////////////////////////////////////
  // '시/도/구/군'으로 주소 검색
  //
  // o 리턴값
  //
  // - False : 에러
  // - String : 서버 측으로부터 예외 메시지
  // - Array(2차원배열) : 주소 결과
  //   Array[n][0] => 우편번호, Array[n][1] => 주소
  ////////////////////////////////////////////////////////////////
  function GetPostBySidoGugun($sido, $gugun) {
    $xml_file = $this->service_server."GetPostBySidoGugunToByte?Sido=".urlencode(trim($sido))."&Gugun=".urlencode(trim($gugun));
    return ( $this->parse_post($xml_file) );
  }

  ////////////////////////////////////////////////////////////////
  // 검색 결과 XML 문서를 분석
  //
  // o 리턴값
  //
  // - False : 에러
  // - String : 서버 측으로부터 예외 메시지
  // - Array(2차원배열) : 주소 결과
  //   Array[n][0] => 우편번호, Array[n][1] => 주소
  ////////////////////////////////////////////////////////////////
  function parse_post($xml_file) {

    if(!$dom = domxml_open_file($xml_file)) {
      $this->ErrMsg = "주소 검색 서버 접속에 실패하였습니다.";
      return false;
    }

    $root = $dom->document_element();
    if(!$nodes = $root->child_nodes()) {
      $this->ErrMsg = "반환된 검색 결과가 없습니다.";
      return false;
    }

    $hangul = new Hangul();
    $hangul->load_codeset("./Hangul_codeset.txt");

    $addr = array();

    for($i = 0; $i < count($nodes); $i++) {
      if($nodes[$i]->node_type() == 1) {
        $content = $hangul->byte2hangul($nodes[$i]->get_content());

        if(substr($content, 0, 10) == "Exception:") {
          return substr($content, 10);
	} else {
          $addr[count($addr)] = explode("\t", $content);
	}
      }
    }

    return $addr;
  }

}

//
// 한글 코드 관련 클래스
//

class Hangul {

  var $_codeset;
  var $_cho;
  var $_jung;
  var $_jong;
  var $error_msg;

  function Hangul($doc="") {
    $this->_cho = array("ㄱ","ㄲ","ㄴ","ㄷ","ㄸ","ㄹ","ㅁ","ㅂ","ㅃ","ㅅ","ㅆ","ㅇ","ㅈ","ㅉ","ㅊ","ㅋ","ㅌ","ㅍ","ㅎ");
    $this->_jung = array("ㅏ","ㅐ","ㅑ","ㅒ","ㅓ","ㅔ","ㅕ","ㅖ","ㅗ","ㅘ","ㅙ","ㅚ","ㅛ","ㅜ","ㅝ","ㅞ","ㅟ","ㅠ","ㅡ","ㅢ","ㅣ");
    $this->_jong = array("","ㄱ","ㄲ","ㄳ","ㄴ","ㄵ","ㄶ","ㄷ","ㄹ","ㄺ","ㄻ","ㄼ","ㄽ","ㄾ","ㄿ","ㅀ","ㅁ","ㅂ","ㅄ","ㅅ","ㅆ","ㅇ","ㅈ","ㅊ","ㅋ","ㅌ","ㅍ","ㅎ");

    if($doc != "no") {
      if(!$this->load_codeset($doc)) $this->error();
    }
  }

  // CodeSet 데이터 로딩
  function load_codeset($fn="") {
    if($fn=="") $fn = dirname(__FILE__) . "/Hangul_codeset.txt";

    if($fp = @fopen($fn, "r")) {
      $this->_codeset = @fread($fp, filesize($fn));
      @fclose($fp);
      $this->_codeset = $this->_codeset;
      return true;
    } else {
      $this->set_error("load_codeset :: File Not Found : $doc");
      return false;
    }
  }

  function byte2hangul($data) {

    $result = "";

    for($pos = 0; $pos < strlen($data); $pos+=4) {
      $code = sprintf("0x%s", substr($data,$pos,4));
      if(!$ret = $this->ksc2hangul($code)) {
        $result .= chr(hexdec(substr($data, $pos, 2)));
        $pos -= 2;
        continue;
      }
      $result .= $ret;
    }

    return $result;

  }

  // KSC5601 => 한글
  function ksc2hangul($code) {
    if(strstr($code, "0x")) $code = hexdec($code);
    if(!$this->is_hcode($code, "KSC5601")) return false;

    $code = sprintf("%04x", $code);
    $pos = strpos($this->_codeset, $code);
    if(($pos - 3) % 13) $pos = strpos($this->_codeset, $code, $pos+1);
    if($pos === false) {
      $this->set_error("ksc2hangul :: Not Exists in KSC5601 Hangul CodeSet : 0x$code");
      return false;
    }

    $char = substr($this->_codeset, $pos-3, 2); // 글자

    return $char;
  }

  function is_hcode($code, $set="KSC5601") {
    $result = false;
    switch(strtoupper($set)) {
      case "KSC5601" :
        if(($code >= 0x8141 && $code <= 0xc8fe)) $result = true;
        else $this->set_error("is_hcode :: Not in KSC5601 Hangul Code Range : $code");
        break;
      case "UNICODE" :
        if(($code >= 0xac00 && $code <= 0xd7a3) || ($code >= 0x1100 && $code <= 0x11f9)) $result = true;
        else $this->set_error("is_hcode :: Not in UNICODE Hangul Code Range : $code");
        break;
    }
    return $result;
  }

  // 에러처리
  function get_error() {
    return $this->error_msg;
  }
  function set_error($msg) {
    $this->error_msg = $msg;
  }
  function error($func="") {
    if($func && @function_exists($func)) $func($this->get_error()); else echo $this->get_error();
    exit;
  }

}
?>
