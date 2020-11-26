function validasi_text(a, b, c){
  var exp=/^[a-zA-Z ]+$/;
  if ($(a).val().match(exp)) {
    if ($(a).val().length >= b && $(a).val().length <= c) {
      //data valide
        return 1;
    }
    else{
      //data tidak valid
      alert("Jumlah Karakter Harus Lebih dari "+ b + " dan Kurang dari "+ c);
      $(a).focus();
      return 0;
    }
  }
  else{
    alert("Inputan Harus Berupa Karaakter dan Tidak Boleh Kosong..!");
    $(a).focus();
    return 0;
  }
  //alert($(a).val());
}
function validasi_email(a, b, c){
  var exp=/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z0-9]{2,4}$/;
  if ($(a).val().match(exp)) {
    if ($(a).val().length >= b && $(a).val().length <= c) {
      //data valide
        return 1;
    }
    else{
      //data tidak valid
      alert("Email Harus Lebih dari "+ b + " dan Kurang dari "+ c);
      $(a).focus();
      return 0;
    }
  }
  else{
    alert("EmailTidak Valid Atau Kosong..!");
    $(a).focus();
    return 0;
  }
}
function validasi_tidak_kosong(a, pesan){
  if ($(a).val().length == 0) {
    alert(pesan);
    $(a).focus();
    return 0;
  }
  else{
    return 1;
  }
}
function validasi_password(a, b, c){
    var exp=/^[0-9a-zA-Z]+$/;
    if ($(a).val().match(exp)) {
      if ($(a).val().length >= b && $(a).val().length <= c) {
        //data valide
          return 1;
      }
      else{
        //data tidak valid
        alert("Password Harus Lebih dari "+ b + " dan Kurang dari "+ c);
        $(a).focus();
        return 0;
      }
    }
    else{
      alert("Password Harus Diisi Karakter atau Angka..!");
      $(a).focus();
      return 0;
    }
}
function validasi_alamat(a, b, c){
  var exp=/^[0-9a-zA-Z ]+$/;
  if ($(a).val().match(exp)) {
    if ($(a).val().length >= b && $(a).val().length <= c) {
      //data valide
        return 1;
    }
    else{
      //data tidak valid
      alert("Alamat Harus Lebih dari "+ b + " dan Kurang dari "+ c);
      $(a).focus();
      return 0;
    }
  }
  else{
    alert("Alamat Harus Diisi Karakter atau Angka..!");
    $(a).focus();
    return 0;
  }
}
function validasi_angka(a, b, c){
  var exp=/^[0-9]+$/;
  if ($(a).val().match(exp)) {
    if ($(a).val().length >= b && $(a).val().length <= c) {
      //data valide
        return 1;
    }
    else{
      //data tidak valid
      alert("Panjang Angka Harus Antara "+ b + " sampai Dengan "+ c );
      $(a).focus();
      return 0;
    }
  }
  else{
    alert("Kotak Harus Diisi dengan Angka..!");
    $(a).focus();
    return 0;
  }
}
function validasi_huruf_angka(a, b, c, pesan){
  var exp=/^[0-9a-zA-Z ]+$/;
  if ($(a).val().match(exp)) {
    if ($(a).val().length >= b && $(a).val().length <= c) {
      //data valide
        return 1;
    }
    else{
      //data tidak valid
      alert(pesan);
      $(a).focus();
      return 0;
    }
  }
  else{
    alert(pesan);
    $(a).focus();
    return 0;
  }
}
function validasi_website(a, b, c){
  var exp=/^[\w\-\.\+]+[a-zA-Z0-9\.\-]+\.[a-zA-Z0-9]{2,4}$/;
  if ($(a).val().match(exp)) {
    if ($(a).val().length >= b && $(a).val().length <= c) {
      //data valide
        return 1;
    }
    else{
      //data tidak valid
      alert("Masukkan Website dengan Benar..!");
      $(a).focus();
      return 0;
    }
  }
  else{
    alert("Masukkan Website dengan Benar..!");
    $(a).focus();
    return 0;
  }
}
