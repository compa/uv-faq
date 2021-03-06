var __ = {};
var op = [];
var _res = "";
$(document).ready(function(){
    $( "form" ).on( "submit", function( event ) {
        if($('#exp1').val() === '' &&
           $('#exp2').val() === '' &&
           $('#exp3').val() === '' &&
           $('#exp4').val() === '' &&
           $('#exp5').val() === '' &&
           $('#exp6').val() === '' &&
           $('#exp7').val() === '' && 
           $('#exp8').val() === '' ){
            $("#msgerror").html("Tienes que Seleccionar al menos una Experiencia");
            $("#msgerror").css("display", "block");
            event.preventDefault();
        } else {
            var materias = [];
            for(var i = 1; i<9; i++)
            {
                var mat = $("#exp"+i).val();
                if( mat !== ''){
                    if (materias.indexOf(mat) === -1){
                        materias.push($("#exp"+i).val());
                        var all_exp = materias.join('|');
                        $("#all_exp").val(all_exp);
                    } else {
                        $("#msgerror").html("No Puedes repetir la misma experiencia: "+ mat);
                        $("#msgerror").css("display", "block");
                        event.preventDefault();
                    }
                } 
            }
        }
    });

    $("#anterior").on('click',function(){
        mov.anterior();
    });
    $("#siguiente").on('click',function(){
        mov.siguiente();
    });

});

var make_url = function(num, res_f){
    for(var i=0;i<res_f.length; i++)
    {
        var ped = res_f[i].split("^");
        var url = ped[1];
        if(ped[0] == num){
            if(url[url.length-1] == ";"){
                return url.slice(0, -1);
            } else {
                return url;
            }
        };
    };
};

var make_lis = function(){
    $("button").on("click", function(){
        _res = $("#std").val().split("#");
        var res_f = _res[1].split("~");
        switch($(this).val())
        {
            case "graph1":
                r = "title|"+_[1].question + ";" + make_url(1, res_f);
                break;
            case "graph2":
                r = "title|"+_[2].question + ";" + make_url(2, res_f);
                break;
            case "graph3":
                r = "title|"+_[3].question + ";" + make_url(3, res_f);
                break;
            case "graph4":
                r = "title|"+_[4].question + ";" + make_url(4, res_f);
                break;
            case "graph5":
                r = "title|"+_[5].question + ";" + make_url(5, res_f);
                break;
            case "graph6": 
                r = "title|"+_[6].question + ";" + _res[0];
                break;
            case "graph7":
                r = "title|"+_[7].question + ";" + make_url(7, res_f);
                break;
            default:

                break;
        }
        $("#main-graphics-graph").html("<iframe style='border:0;width:740px; height:600px;' src='/Entre_Pares/algo.php?data="+ r +"'></iframe>");

    });
};

var FQA = function(){
    this.number = 1;
    this.chunkHtml = "";
    this.MatSelec = [];
    this.render();
};

FQA.prototype.siguiente = function() {
    this.save();
    if(!this.partial_check()){ return false; };
    if(this.number < 7){
        $("#msgerror").css("didisplaysplay", "none");
        this.number = this.number + 1 ;
        this.render();
        this.set();
        if(this.number == 7){ 
            $("#siguiente").removeClass("btn btn-info").addClass("btn btn-danger");
            $("#siguiente").text("Finalizar");
        }
    } else {
        //if(!this.check()) return false;
        this.prepare();
        var request = $.ajax({
            url: "/Entre_Pares/",
            type: "POST",
            data: { 'json' : __ }
        });
    
        request.done(function (response, textStatus, jqXHR){
             $("#std").val(response);
            if( response == "Something is wrong")
            {
                $("#main-ask").html("Algo Malo Sucedio. Por favor, Intentalo de Nuevo");
            } else {
                $("#main-ask").html("<h2>Gracias!</h2>");                
            }
        });
    };
};

FQA.prototype.anterior = function() {
    this.save();
    if(!this.partial_check()){ return false; };
    if(this.number > 1){
        $("#msgerror").css("display", "none");
        $("#siguiente").text("Siguiente");
        $("#siguiente").removeClass("btn btn-danger").addClass("btn btn-info");
        this.number = this.number - 1 ;
        this.render();
        this.set();
    }
};



FQA.prototype.prepare = function(){
    var bck = [];
    __ = $.extend(true, {}, _); // Make a deep clone (jQuery);
    for(var i =1; i< 8;i++)
    {
        bck = __[i].answers;
        delete __[i].answers;
        __[i].answers = [];
        var json = {};
        for (var f in bck){
            json[f] = bck[f];
        }
        __[i].answers.push(json);
    }
};

FQA.prototype.partial_check = function(){
    var i = this.number;
    if(_[i].type != "CB-E" ){
        chk  = _[i].answers;
        if(i !== 7){
            for (var j=0;j<gMaterias.length;j++){
                if(!chk[gMaterias[j]]){
                    $("#msgerror").html("Tienes que escoger todas las opciones");
                    $("#msgerror").css("display", "block");
                    return false;
                }
            }
        }else{
            for (var j=0;j<gMaterias.length;j++){
                if(!chk[gMaterias[j]]){
                    for(var x in _[6].answers){
                        if(gMaterias[j] == x.split(' ').join('_')){
                            $("#msgerror").html("Tienes que escoger todas las opciones");
                            $("#msgerror").css("display", "block");
                            return false;
                        }
                    }
                }
            }
        }
    }
    $("#msgerror").css("display", "none");
    return true;
};

FQA.prototype.check = function(){
    var chk = [];
    for(var i=1; i<=Object.keys(_).length; i++){
        if(_[i].type != "CB-E" ){
            chk  = _[i].answers;
            for (var j=0;j<gMaterias.length;j++){
                if(!chk[gMaterias[j]]){
                    $("#msgerror").html("Tienes que escoger todas las opciones");
                    $("#msgerror").css("display", "block");
                    return false;
                }
            }
        }
    }
    return true;
};

FQA.prototype.set = function(){
    var anws = [];
    anws = _[this.number].answers;
    for (var x in anws){
        if(this.number === 6){
            $('.CBMAT').each(function(){
                var checkbox = $(this);
                if(checkbox.val() == x){
                    checkbox.attr('checked',true);
                }
            });
        } else { 
            $("input[name="+ this.number +"_"+ x+"][value="+ anws[x] +"]").prop("checked", true);  
        }
    }
};

FQA.prototype.save = function(){
    this.MatSelec =[];
    var MatSelecCB = []
    if(this.number === 6)
    {
        $('.CBMAT').each(function(){
            var checkbox = $(this);
            if(checkbox.is(':checked')){
                MatSelecCB[checkbox.val()] = true; 
            }
        });
        this.MatSelec = MatSelecCB;
    } else {
        for(var i=0;i<gMaterias.length;i++){
            this.MatSelec[gMaterias[i]] = $("input[name="+ this.number +"_"+ gMaterias[i] +"]:checked").val();
        }
    }
    _[this.number].answers = this.MatSelec;
};

FQA.prototype.render = function() {
    this.chunkHtml = "";
    this.chunkHtml += _[this.number].question;
    this.chunkHtml += "<hr>";
    /* bueno regular malo */
    if(_[this.number].type == "CB-E"){
        this.chunkHtml += "<class='panel panel-success' style='width:300px;margin:10px auto;display:inline-block;'>";
        this.chunkHtml += "<div class='panel-heading'>";
        this.chunkHtml += "<h3 class='panel-title'>Experiencias</h3>"
        this.chunkHtml += "</div>";
        this.chunkHtml += "<div class='panel-body'>";
        this.chunkHtml += "<table  class='table table-striped' style='width:200px;margin:0 auto;'>";
        for(var i=0;i<gMaterias.length;i++)
        {
            
            this.chunkHtml +="<tr><td><input type='checkbox' class='CBMAT' value='"+ gMaterias[i].split('_').join(' ') +"'></td><td>"+ gMaterias[i].split('_').join(' ') +"</td></tr>";
              
        } 
        this.chunkHtml +="</table>";
        this.chunkHtml +="</div>";
        this.chunkHtml +="</div>";
    } else {
        this.chunkHtml += "<table class='table table-hover'><thead><tr><th syle='text-align:center;'>Materia</th>";
        for(var k=0;k<_[this.number].options.length;k++){
            this.chunkHtml +="<td>" + _[this.number].options[k]+"</td>";
        }
        for (var i=0; i<gMaterias.length; i++){
            var flag = true;
            this.chunkHtml += "</tr></thead>";
            this.chunkHtml += "<tbody>";
            if(this.number !== 7 ){ this.chunkHtml += "<tr><td>"+ gMaterias[i].split('_').join(' ')+"</td>"; }
            for(var q=0;q<_[this.number].options.length;q++){
                if (this.number === 7){
                    for(var x in _[6].answers) { 
                        if (x == gMaterias[i].split('_').join(' ')){
                            if(flag){
                                this.chunkHtml += "<tr><td>"+ gMaterias[i].split('_').join(' ')+"</td>"; 
                                flag = false;
                            }
                            this.chunkHtml +="<td><input type='radio' name='"+ this.number+"_"+ gMaterias[i] +"' value='"+ _[this.number].options[q].split(' ').join('_')+"'></td>";          
                        }
                    }
                } 
                else 
                {
                    this.chunkHtml +="<td><input type='radio' name='"+ this.number+"_"+ gMaterias[i] +"' value='"+ _[this.number].options[q].split(' ').join('_')+"'></td>";
                }
            }    
            this.chunkHtml += "</tr>";
        }
        this.chunkHtml += "</tbody></table>"; 
    }
    $("#pregunta").html(this.chunkHtml);
};