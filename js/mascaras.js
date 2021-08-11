function ResetCampos()
{
    for(var o=document.getElementsByTagName("input"),e=0;e<o.length;e++)
    "text"==o[e].type&&(o[e].style.backgroundColor="",o[e].style.borderColor="")
}
    
    function mascara(o,e,r,t)
    {var l=e.selectionStart,a=e.value;a=a.replace(/\D/g,"");var s=a.length,c=o.length;window.event?id=r.keyCode:r.which&&(id=r.which),cursorfixo=!1,l<s&&(cursorfixo=!0);var n=!1;if((16==id||19==id||id>=33&&id<=40)&&(n=!0),ii=0,mm=0,!n){if(8!=id)for(e.value="",j=0,i=0;i<c&&("#"==o.substr(i,1)?(e.value+=a.substr(j,1),j++):"#"!=o.substr(i,1)&&(e.value+=o.substr(i,1)),8==id||cursorfixo||l++,j!=s+1);i++);t&&coresMask(e)}cursorfixo&&!n&&l--,e.setSelectionRange(l,l)}var corCompleta="#FFFAFA",corIncompleta="#FFFAFA";
   
    
    function verifica() {
      if (document.forms[0].email.value.length == 0) {
        alert('Por favor, informe o seu EMAIL.');
      document.frmEnvia.email.focus();
        return false;
      }
      return true;
    }


      function checarEmail(){
      if( document.forms[0].email.value=="" 
         || document.forms[0].email.value.indexOf('@')==-1 
           || document.forms[0].email.value.indexOf('.')==-1 )
        {
          alert( "Por favor, informe um E-mail válido!" );
          return false;
        }
      }

      
      function moeda(a, e, r, t) {
        let n = ""
          , h = j = 0
          , u = tamanho2 = 0
          , l = ajd2 = ""
          , o = window.Event ? t.which : t.keyCode;
        if (13 == o || 8 == o)
            return !0;
        if (n = String.fromCharCode(o),
        -1 == "0123456789".indexOf(n))
            return !1;
        for (u = a.value.length,
        h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
            ;
        for (l = ""; h < u; h++)
            -1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
        if (l += n,
        0 == (u = l.length) && (a.value = ""),
        1 == u && (a.value = "0" + r + "0" + l),
        2 == u && (a.value = "0" + r + l),
        u > 2) {
            for (ajd2 = "",
            j = 0,
            h = u - 3; h >= 0; h--)
                3 == j && (ajd2 += e,
                j = 0),
                ajd2 += l.charAt(h),
                j++;
            for (a.value = "",
            tamanho2 = ajd2.length,
            h = tamanho2 - 1; h >= 0; h--)
                a.value += ajd2.charAt(h);
            a.value += r + l.substr(u - 2, u)
        }
        return !1
    }
 
 function formataCampo(campo, Mascara) {
                                    var er = /[^0-9/ (),.-]/;
                                    er.lastIndex = 0;

                                    if (er.test(campo.value)) { ///verifica se é string, caso seja então apaga
                                        var texto = $(campo).val();
                                        $(campo).val(texto.substring(0, texto.length - 1));
                                    }
                                    var boleanoMascara;
                                    var exp = /\-|\.|\/|\(|\)| /g
                                    var campoSoNumeros = campo.value.toString().replace(exp, "");
                                    var posicaoCampo = 0;
                                    var NovoValorCampo = "";
                                    var TamanhoMascara = campoSoNumeros.length;
                                    for (var i = 0; i <= TamanhoMascara; i++) {
                                        boleanoMascara = ((Mascara.charAt(i) == "-") || (Mascara.charAt(i) == ".") ||
                                            (Mascara.charAt(i) == "/"))
                                        boleanoMascara = boleanoMascara || ((Mascara.charAt(i) == "(") ||
                                            (Mascara.charAt(i) == ")") || (Mascara.charAt(i) == " "))
                                        if (boleanoMascara) {
                                            NovoValorCampo += Mascara.charAt(i);
                                            TamanhoMascara++;
                                        } else {
                                            NovoValorCampo += campoSoNumeros.charAt(posicaoCampo);
                                            posicaoCampo++;
                                        }
                                    }
                                    campo.value = NovoValorCampo;
                                    ////LIMITAR TAMANHO DE CARACTERES NO CAMPO DE ACORDO COM A MASCARA//
                                    if (campo.value.length > Mascara.length) {
                                        var texto = $(campo).val();
                                        $(campo).val(texto.substring(0, texto.length - 1));
                                    }
                                    //////////////
                                    return true;
                                }
  function MascaraGenerica(seletor, tipoMascara) {
                                    setTimeout(function() {
                                        if (tipoMascara == 'CPFCNPJ') {
                                            if (seletor.value.length <= 14) { //cpf
                                                formataCampo(seletor, '000.000.000-00');
                                            } else { //cnpj
                                                formataCampo(seletor, '00.000.000/0000-00');
                                            }
                                        } else if (tipoMascara == 'DATA') {
                                            formataCampo(seletor, '00/00/0000');
                                        } else if (tipoMascara == 'CEP') {
                                            formataCampo(seletor, '00.000-000');
                                        } else if (tipoMascara == 'TELEFONE') {
                                            formataCampo(seletor, '(00) 000000000');
                                        }
                                    }, 200);
                                }