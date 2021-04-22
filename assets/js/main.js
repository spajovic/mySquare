$('document').ready(function(){
    // Ispisivanje kategorija
    $.ajax({
        url:'logic/category.php',
        type:'post',
        data:{
            uspelo:true
        },
        dataType:'json',
        success: function(data){
            let ispis = ``;
            data.forEach(function(el){
                ispis+=`
                <a href="#" class="list-group-item kat" data-id="${el.categoryId}">${el.categoryName}</a>
                `;
            });
            ispis2 = ``;
            data.forEach(function(el){
                ispis2 +=`
                <option value="${el.categoryId}">${el.categoryName}</option>`; 
            });
            $('#ddl-update1').html(ispis2);
            $('#ddl-insert1').html(ispis2);
            $('#kategorije').html(ispis);
            $('.kat').on('click',function(e){
                e.preventDefault();
                let id = this.dataset.id;
                $.ajax({
                    url:'logic/filter.php?id='+id,
                    type:'get',
                    dataType:'json',
                    success:function(data){
                        console.log(data);
                        ispisiZgrade(data);
                    },
                    error:function(xhr,status,error){
                        console.log(xhr.status);
                    }
                })
            });
        },
        error:function(error){
            console.log(error);
        }
    });

    // Funkcija za ispisivanje zgrade
    function ispisiZgrade(data){
        let ispis = ``;
                data.forEach(function(el){
                    ispis+=`
                    <div class="col-lg-4 col-md-6 mb-4 buildings">
                    <div class="card h-100">
                      <a href="building.php?id=${el.id}"><img class="card-img-top" src="assets/img/${el.src}" alt="${el.alt}"></a>
                      <div class="card-body">
                        <h4 class="card-title">
                          <a href="building.php?id=${el.id}" data-id="${el.id}">${el.name}</a>
                        </h4>
                        <h5>$${el.price}</h5>
                        <p class="card-text">${el.shortInfo}</p>
                      </div>
                      <div class="card-footer">
                      <a href="building.php?id=${el.id}" data-id="${el.id}">More info -></a>
                      </div>
                    </div>
                  </div>     
                    `;
                });
                $('#zgrade').html(ispis);
    }

    // Ispisivanje navigacije

    $.ajax({
        url:'logic/navigacija.php',
        type:'post',
        dataType:'json',
        data:{
            stiglo:true
        },
        success:function(data){
            let ispis = ``;
            data.forEach(function(el){
                ispis+= `
                <li class="nav-item">`
                if(el.ime == "Author"){
                    ispis+=`<a class="nav-link" href="${el.href}" target="_blank">${el.ime}</a>
                </li>
                `;
                }
                else{
                ispis+=`<a class="nav-link" href="${el.href}">${el.ime}</a>
                </li>
                `;
                }
            })
            $('#dinamicki-meni').html(ispis);
        },
        error: function(xhr,status,error){
            console.log(xhr.responseText);
        }
    });
    // Ispisivanje navigacije za ulogovane korisnike
    $.ajax({
        url:'logic/navigacijalog.php',
        type:'get',
        dataType:'json',
        success:function(data){
            let ispis = ``;
            data.forEach(function(el){
                ispis+= `
                <li class="nav-item">`
                if(el.ime == "Author"){
                    ispis+=`<a class="nav-link" href="${el.href}" target="_blank">${el.ime}</a>
                </li>
                `;
                }
                else if(el.ime == "Home"){
                    ispis+=`<a class="nav-link" href="${el.href}">${el.ime}</a>
                </li>
                `;
                }
                else{
                ispis+=`<a class="nav-link" href="logic/${el.href}">${el.ime}</a>
                </li>
                `;
                }
            });
            $('#dinamicki-log').html(ispis);
        },
        error: function(xhr,status,error){
            console.log(xhr.responseText);
        }
    });

    // Ispisi u ddl za update i insert

    $.ajax({
        url:"logic/graditelji.php",
        dataType:'json',
        success:function(data){
            let ispis = ``;
            data.forEach(function(el){
                ispis +=`
                    <option value="${el.id}">${el.name}</option>`;
            });
            $('#ddl-update').html(ispis);
            $('#ddl-insert').html(ispis);
        },
        error:function(xhr,status){
            console.log(xhr);
        }
    });

    // Provera forme za registraciju na klijentu
    $('#dugme').on('click',function(){
        let imeVrednost = $('#ime1').val();
        let prezimeVrednost = $('#prezime1').val();
        let usernameVrednost = $('#username1').val();
        let emailVrednost = $('#mail1').val();
        let sifraVrednost = $('#sifra1').val();
        let ponoviSifru = $('#sifra2').val();
        let greske = [];
        let proveraTekst = /^[A-ZĐŠŽĆČ][a-zđšžćč]{1,21}$/;
        let proveraUsername = /^[A-ZĐŠŽĆČa-zđšžćč0-9]+(?:[ _-][A-Za-z0-9]+)*$/;
        let proveraMail = /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/;
        let proveraaSifre = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,21}$/;
        if(proveraTekst.test(imeVrednost)){
            $('#ime1').css({border:"1px solid green"});
        }
        else{
            $('#ime1').css({border:"1px solid red"});
            greske.push("Name is invalid");
        }
        if(proveraTekst.test(prezimeVrednost)){
            $('#prezime1').css({border:"1px solid green"});
        }
        else{
            $('#prezime1').css({border:"1px solid red"});
            greske.push("Surname is invalid");
        }
        if(proveraUsername.test(usernameVrednost)){
            $('#username1').css({border:"1px solid green"});
        }
        else{
            $('#username1').css({border:"1px solid red"});
            greske.push("Username is invalid");
        }
        if(proveraMail.test(emailVrednost)){
            $('#mail1').css({border:"1px solid green"});
        }
        else{
            $('#mail1').css({border:"1px solid red"});
            greske.push("Mail is invalid");
        }
        if(proveraaSifre.test(sifraVrednost)){
            $('#sifra1').css({border:"1px solid green"});
        }
        else{
            $('#sifra1').css({border:"1px solid red"});
            greske.push("Password is invalid");
        }
        if(sifraVrednost == ponoviSifru){
            $('#sifra2').css({border:"1px solid green"});
        }
        else{
            $('#sifra2').css({border:"1px solid red"});
            greske.push("Passwords don't match");
        }
        if(greske.length){
            for(let gres of greske){
                alert(gres);
            }
        }
        else{
            $.ajax({
                url:'logic/registracija.php',
                type:'post',
                data:{
                    ime:imeVrednost,
                    prezime:prezimeVrednost,
                    username:usernameVrednost,
                    mail:emailVrednost,
                    sifra:sifraVrednost,
                    sifraopet:ponoviSifru,
                    stiglo:true
                },
                success: function(data){
                    alert(data);
                    if(data == 'Registered successfully, head over to the LogIn page'){
                        location.replace('http://localhost/php1sajt/login.php');
                    }
                },
                error:function(error,status,xhr){
                    let message = "Error";
                    switch(xhr.status){
                        case 404:
                            message = "Page not found";
                            break;
                        case 409:
                            message = "Username or email exists";
                            break;
                        case 422:
                            message = "Not valid";
                            break;       
                        case 500:
                            message = "Server is experiencing some errors, please try again later";
                            break; 
                    }
                    alert(message);
                }
            })
        }
    });


    // Provera forme za logovanje na klijentu
    $('#dugme1').on('click',function(){
        let usernameVrednost = $('#username2').val();
        let sifraVrednost = $('#sifra3').val();
        let proveraUsername = /^[A-ZĐŠŽĆČa-zđšžćč0-9]+(?:[ _-][A-Za-z0-9]+)*$/;
        let proveraaSifre = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,21}$/;
        let greske = [];
        if(proveraUsername.test(usernameVrednost)){
        }
        else{
            $('#username2').css({border:"1px solid red"});
            greske.push("malo greska");
        }
        if(proveraaSifre.test(sifraVrednost)){  
        }
        else{
            $('#sifra3').css({border:"1px solid red"});
            greske.push("malo greska");
        }
        if(greske.length){
            alert("Make sure your incredentials are correct");
        }
        else{
            // LOGOVANJE
            $.ajax({
                url:'logic/logovanje.php',
                type:'post',
                data:{
                    username:usernameVrednost,
                    sifra:sifraVrednost,
                    stiglo:true
                },
                success:function(data){
                    if(data == "Username or password is invalid"){
                        alert(data);
                    }
                    if(data.role == "admin"){
                        location.replace('http://localhost/php1sajt/baza.php');
                    }
                    else{
                        location.replace('http://localhost/php1sajt/question.php');
                    }
                },
                error:function(error,status,xhr){
                    let message = "Make sure your incredentials are correct";
                    switch(xhr.status){
                        case 404:
                            message = "Page not found";
                            break;
                        case 409:
                            message = "Username or email exists";
                            break;
                        case 422:
                            message = "Not valid";
                            break;       
                        case 500:
                            message = "Server is experiencing some errors, please try again later";
                            break; 
                    }
                    alert(message);
                }

            });
        }
    });
    // Upisivanje komentara
    $('#dugme-komentar').on('click',function(){
        let id = this.dataset.id;
        let komentarVrednost = $('#komentar').val();
        let proveraKomentar = /^[a-zđšžćčA-ZĐŠŽĆČ.,;!?:'\%\\\-\.]{1,} [a-zđšžćčA-ZĐŠŽĆČ.,:?;!]{1,} .+$/;
        if(proveraKomentar.test(komentarVrednost)){
            $('#komentar').css({border:"1px solid green"});
            $.ajax({
                url:'logic/upiskomentara.php',
                type:'post',
                data:{
                    zgradaId:id,
                    komentar:komentarVrednost,
                    stiglo:true
                },
                success:function(data){
                    alert(data);
                    if(data == "Successfully commented, please refresh page"){
                        location.replace('http://localhost/php1sajt/building.php?id='+id);
                    }
                    
                },
                error:function(error){
                    console.log(error);
                }
            })
        }
        else{
            $('#komentar').css({border:"1px solid red"});
        }
    });
    // Upisivanje u formu za update zgrada
    $(".dgmUp").on("click",function(){
        let id = this.dataset.id;
        $.ajax({
            url:'logic/popuniupdate.php',
            type:'POST',
            data:{
                id:id,
                stiglo:true
            },
            success:function(data){
                    $('#ddl-update').val(data.gradid);
                    $('#ddl-update1').val(data.katid);
                    $('#update-name').val(data.ime);
                    $('#update-price').val(data.cena);
                    $('#update-location').val(data.lokacija);
                    $('#infoDug').val(data.duzi);
                    $('#infoKrat').val(data.kraci);
                    $('#ddl-update2').val(data.konst);
                    $('#sakriveno').val(id);
            },
            error:function(xhr,error){

            }
        })
    });
    // Provera forme za update
    $('#update-dugme').on("click",function(){
        let id = $('#sakriveno').val();
        let ddl_update = $('#ddl-update').val();
        let ddl_update1 = $('#ddl-update1').val();
        let update_price = $('#update-price').val();
        let update_name = $('#update-name').val();
        let update_location = $('#update-location').val();
        let ddl_update2 = $('#ddl-update2').val();
        let longtxt = $('#infoDug').val();
        let shorttxt = $('#infoKrat').val();
        let proveraCene = /^[0-9]{1,10}.00$/;
        let proveraIme = /^[A-ZĐŠŽĆČa-zđšžćč0-9\s]{2,29}$/;
        let proveraLokacije = /^[A-ZĐŠŽĆČ][a-zđšžćč]{1,40},\s{0,1}[A-ZĐŠŽĆČ][a-zđšžćč]{1,40}$/;
        let proveraInfo = /^[a-zđšžćčA-ZĐŠŽĆČ.,;!?:'\%\\\-\.]{1,} [a-zđšžćčA-ZĐŠŽĆČ.,:?;!]{1,} .+$/;
        let greskice = [];
        if(!(proveraCene.test(update_price))){
            $('#update-price').css({border:'1px solid red'});
            greskice.push("Price is invalid");
        }
        if(!(proveraLokacije.test(update_location))){
            $('#update-location').css({border:'1px solid red'});
            greskice.push("Location is invalid");
        }
        if(!(proveraIme.test(update_name))){
            $('#update-name').css({border:'1px solid red'});
            greskice.push("Name is invalid");
        }
        if(!(proveraInfo.test(longtxt))){
            $('#infoDug').css({border:'1px solid red'});
            greskice.push("Long info is invalid");
        }
        if(!(proveraInfo.test(shorttxt))){
            $('#infoKrat').css({border:'1px solid red'});
            greskice.push("Short info is invalid");
        }
        if(greskice.length){
            for(let greska of greskice){
                alert(greska);
            }
        }
        else{
            $.ajax({
                url:'logic/updatezgrade.php',
                type:"post",
                data:{
                    stiglo:true,
                    gradid:ddl_update,
                    katid:ddl_update1,
                    ime:update_name,
                    cena:update_price,
                    lokacija:update_location,
                    longtxt:longtxt,
                    shorttxt:shorttxt,
                    konst:ddl_update2,
                    id:id
                },
                success:function(data){
                    alert(data);
                    if(data =="Updated successfully, please refresh"){
                    location.replace('http://localhost/php1sajt/baza.php');
                    }
                },
                error:function(xhr,status,error){
                    let message = "Error";
                    switch(xhr.status){
                        case 404:
                            message = "Page not found";
                            break;
                        case 409:
                            message = "Something went worng";
                            break;
                        case 422:
                            message = "Not valid";
                            break;       
                        case 500:
                            message = "Server is experiencing some errors, please try again later";
                            break; 
                    }
                    alert(message);
                }
            });
        }
    });

    // Brisanje zgrada

    $('.dgmDelete').on('click',function(){
        let id = this.dataset.id;
        $.ajax({
            url:'logic/deletezgradu.php',
            type:'post',
            data:{
                stiglo:true,
                id:id
            },
            success:function(data){
                alert(data);
                if(data == "Building deleted successfully"){
                    location.reload();
                }
            },
            error(xhr,err,error){
                alert(xhr.responseText);
            }
        });
    });

    // INSERT U TABELU 
    $('#insertDgm').on('click',function(){
        let ddl_insert = $('#ddl-insert').val();
        let ddl_insert1 = $('#ddl-insert1').val();
        let insert_price = $('#insert-price').val();
        let insert_name = $('#insert-name').val();
        let insert_location = $('#insert-location').val();
        let ddl_insert2 = $('#ddl-insert2').val();
        let longtxt1 = $('#infoDug1').val();
        let shorttxt1 = $('#infoKrat1').val();
        let picture_src = $('#insert-src').val();
        let proveraCene = /^[0-9]{1,10}.00$/;
        let proveraIme = /^[A-ZĐŠŽĆČa-zđšžćč0-9\s]{2,29}$/;
        let proveraLokacije = /^[A-ZĐŠŽĆČ][a-zđšžćč]{1,40},\s{0,1}[A-ZĐŠŽĆČ][a-zđšžćč]{1,40}$/;
        let proveraInfo = /^[a-zđšžćčA-ZĐŠŽĆČ.,;!?:'\%\\\-\.]{1,} [a-zđšžćčA-ZĐŠŽĆČ.,:?;!]{1,} .+$/;
        let proveraPicture = /(.{2,95})\.jpg/;
        let greskice = [];
        console.log(picture_src);
        if(!(proveraCene.test(insert_price))){
            $('#insert-price').css({border:'1px solid red'});
            greskice.push("Price is invalid");
        }
        if(!(proveraIme.test(insert_name))){
            $('#insert-name').css({border:'1px solid red'});
            greskice.push("Name is invalid");
        }
        if(!(proveraLokacije.test(insert_location))){
            $('#insert-location').css({border:'1px solid red'});
            greskice.push("Location is invalid");
        }
        if(!(proveraInfo.test(longtxt1))){
            $('#infoDug1').css({border:'1px solid red'});
            greskice.push("Long info is invalid");
        }
        if(!(proveraInfo.test(shorttxt1))){
            $('#infoKrat1').css({border:'1px solid red'});
            greskice.push("Short info is invalid");
        }
        if(!(proveraPicture.test(picture_src))){
            $('#insert-src').css({border:"1px solid red"});
            greskice.push("Src is invalid");
        }
        if(greskice.length){
            for(let greska of greskice){
                alert(greska);
            }
        }
        else{
            $.ajax({
                url:'logic/insertzgrade.php',
                type:'post',
                data:{
                    gradid:ddl_insert,
                    katid:ddl_insert1,
                    cena:insert_price,
                    ime:insert_name,
                    lokacija:insert_location,
                    longtxt1:longtxt1,
                    shorttxt1:shorttxt1,
                    konst:ddl_insert2,
                    src:picture_src,
                    stiglo:true
                },
                success:function(data){
                    alert(data);
                    if(data == "Property inserted successfully, please refresh page"){
                        location.replace('http://localhost/php1sajt/baza.php');
                    }
                },
                error:function(xhr,error,status){
                    console.log(xhr.responseText);
                }
            });
        }  
    });
    // DELETE Komentara
    $('.komDelete').on("click",function(){
        let id = this.dataset.id;
        $.ajax({
            url:'logic/deletekomentar.php',
            type:'post',
            data:{
                stiglo:true,
                id:id
            },
            success: function(data){
                alert(data);
                if(data == "Comment deleted successfully,please refresh page"){
                    location.replace('http://localhost/php1sajt/baza.php');  
                }
            },
            error(xhr,err,error){
                console.log(error);
            }

        });
    });

    // DELETE korisnika "user"
    $('.userDelete').on("click",function(){
        let id = this.dataset.id;
        $.ajax({
            url:'logic/deletekorisnik.php',
            type:'post',
            data:{
                stiglo:true,
                id:id
            },
            success: function(data){
                alert(data);
                if(data == "User deleted successfully, please refresh page"){
                    location.replace('http://localhost/php1sajt/baza.php');  
                }
            },
            error(xhr,err,error){
                console.log(error);
            }

        });
    });
    // Uzimanje vrednosti sa Question stranice
    $('#dgmVote').on("click",function(){
        ddl_vote = $('#ddl-vote').val();
        $.ajax({
            url:"logic/glasovi.php",
            type:'post',
            data:{
                stiglo:true,
                vote:ddl_vote
            },
            success:function(data){
                alert(data);
                location.replace('http://localhost/php1sajt/index.php');
            },
            error: function(err, error, xhr){
                console.log(err);
            }
        });
    });

});

