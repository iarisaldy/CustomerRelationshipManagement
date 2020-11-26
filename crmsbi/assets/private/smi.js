/*
1. Event yang Ada dalam SMI 
	a. onclick
	b. ondblclick
	c. 
2. Get dan Set Input Data By ID or CLASS
	a. Val() // untuk get value dan set value
	b. Html() // Untuk Get HTML dan Set Html
	c. Input() // untuk Input file yang tidak ada pada form action
	d. Attr() // Digunakan untuk Mengambil nilai yang disisipkan melalui attr.

3. Ajax
	a. $MI.AJAX()// ajax untuk program smi.
	
4. form Submit Encription
	a. 
*/

function $MI_SCURITY_01(){
	
	return <?php echo $BHS_ENCRIPTION; ?>

	// $MI_AJAX({     
	// 	url			: 'http://localhost/150/SMICRM/https/index.php?ra=0000001l0100l00111l110000l00010l0000001l011100l000111l001110l111110l0000001l1000l011l001l0000001l',
	// 	methode 	: 'POST',
	// 	HASIL 		: function(hasil){
			
	// 		nilai_enk = data.data(hasil, data.nilai);
			
	// 	}
	// });
}

//=========================================================================================JS FORM SUBMIT
form_smi();
function form_smi(){//
    Form_element = document.getElementsByTagName("form");

    for(var x = 0, len = Form_element.length; x < len; x++) {

        if(Form_element[x].getAttribute("smi")!=null){//hanya form SMI yang akan di proses
            if(Form_element[x].getAttribute("smi").toUpperCase()=='FORM'){//jika smi =form dilanjutkan
                Form_element[x].onclick = handleClick;
            }
              
        }
    }

    function handleClick() {//disini eksekusi form klik
        
        for(i=0; i<this.elements.length; i++){
            
            if(this.elements[i].getAttribute("smi")!=null && 
                this.elements[i].getAttribute("smi").toUpperCase()=='INPUT'){
            	nilai = this.elements[i].value;
                this.elements[i].value=$MI().Input(nilai);
            }
        }
        //jika mau melakukan submit encriptison functon controller.
    }
}
//=========================================================================================




//===================================================================================================SMI $SMI OPEN
function $MI(classid=null){
	
	encription = function(a){
		var hasil = $MI_SCURITY_01();//JSON.parse(Bahasa);
		variable = a;

		text_encripsi = '';
		for(i=0; i<variable.length; i++){
			index = variable.charAt(i);
			if(index==' '){
				text_encripsi = text_encripsi + 'SMIl';
			}
			else {
				text_encripsi = text_encripsi+hasil.ENK[index]+'l';	
			}

		}
		return text_encripsi;
	}

	if(classid!=null){//cek klass id agar tidak kosong
		nilai 		= null;
		obj_nilai 	= null;
		nm_class_id = classid.substring(1, classid.lenght);

		if(classid.charAt(0)=='.'){	//jika data klasss maka berikut prosesnya.
			obj_nilai = document.getElementsByClassName(nm_class_id)[0].getAttribute("smi");
			if(obj_nilai!=null){
				obj_nilai = obj_nilai.toUpperCase();
			
				if(obj_nilai=='INPUT'){//pengecekan apakah nilai perlu diamanakan.

					return {
						Val		: function(a=null){
							if(a==null){
								nilai = document.getElementsByClassName(nm_class_id)[0].value;//nilai pada object pertama
								return encription(nilai);
							}
							else {
								document.getElementsByClassName(nm_class_id)[0].value = a;
							}	
						},
						Html	: function(a=null){
							if(a==null){
								nilai = document.getElementsByClassName(nm_class_id)[0].innerHTML;//nilai pada object pertama
								return encription(nilai);
							}
							else {
								document.getElementsByClassName(nm_class_id)[0].innerHTML = a;
							}
						},
						Attr 	: function(a=null){
							if(a != null){
								atribut =  document.getElementsByClassName(nm_class_id)[0].getAttribute(a);
								return encription(atribut);
							}
						}
					}

				}
				else {
					//errror karena atribut smi="input" tidak ada.
				}
			}
			else {
				//jika tidak ada tribut smi dalam tag maka error.	 
			}
			
		}
		else if(classid.charAt(0)=='#'){//
			obj_nilai = document.getElementById(nm_class_id).getAttribute("smi");
			
			if(obj_nilai!=null){
				obj_nilai = obj_nilai.toUpperCase();

				if(obj_nilai == 'INPUT'){
					
					return {
						Val		: function(a=null){
							if(a==null){
								nilai = document.getElementById(nm_class_id).value//nilai pada object pertama
								return encription(nilai);
							}
							else {
								document.getElementById(nm_class_id).value = a;
							}	
						},
						Html	: function(a=null){
							if(a==null){
								nilai = document.getElementById(nm_class_id).innerHTML;//nilai pada object pertama
								return encription(nilai);
							}
							else {
								document.getElementById(nm_class_id).innerHTML = a;
							}
						},
						Attr  	: function(a=null){
							if(a != null){
								atribut =  document.getElementById(nm_class_id).getAttribute(a);
								return encription(atribut);
							}
							
						},
					}

				}
			}
			else {
				//jika tidak ada atribut smi dalam tag maka akan di buat error.
			}
			
		}
		else {
			//tidak Diketahui klass atau id yang akan diproses.
		}
	
	}
	else {//Jika kelas dan Id parameter function kosong.
		return {
			Input : function(a=null){
				if(a!=null){
					hasil_encription = encription(a);
					return hasil_encription;
				}
				else {
					return a;
				}
			}
		}
	}
}

//===================================================================================================SMI $SMI CLOSE


//======================================================================================================SMI AJAX OPEN
function $MI_AJAX(data){//==============================================================================start AJAX

	parameter = '';
	if(typeof data.data != "undefined"){//disini pembuatan parameter jika diperlukan.

		for(x in data.data){
			parameter = parameter + x + '=' + data.data[x] +'&';
		}
	}

	var xhttp;
	if (window.XMLHttpRequest) {
	    // code for modern browsers
	    xhttp = new XMLHttpRequest();
	} else {
	    // code for IE6, IE5
	 	xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	methode = data.methode.toUpperCase();
	if(methode=='POST'){
		xhttp.open(methode, data.url, true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  		xhttp.send(parameter);
	}
	else if(methode=='GET'){
		xhttp.open(methode, data.url+ "?"+ parameter, true);
  		xhttp.send();
	}
	else {
		alert('SMI Scurity : Error Ajax ..');
	}  
	
	if(typeof data.PROGRESS != "undefined"){//data progress dijalankan
		xhttp.onprogress = function(){
			data.PROGRESS(xhttp.status);
		}
	}

	if(typeof data.HASIL!= "undefined"){
		xhttp.onload = function () {//memanggil function hasil dari ajax
			data.HASIL(xhttp.responseText);
		}	
	}
	//==================================================================================================//end AJAX

}

//======================================================================================================SMI AJAX
