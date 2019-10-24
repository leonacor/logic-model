<?php
session_start();
if(!isset($_SESSION['lgn']))
{
    header('Location: https://www.caransoluciones.com.mx/');
}
?>
<!DOCTYPE html>
<html>
    <head>
<title>CARAN PLEV</title>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="icon" href="../images/favicon.png" />
<link rel="stylesheet" href="../styles/cssW3.css" />
<link rel="stylesheet" href="../styles/cssTemplate.css" />
</head>
<body>
<script src="../scripts/jquery.min.js"></script>
<script src="../scripts/jsResources.js"></script>
<script src="../scripts/jsFa.min.js"></script>
<script>
    var objResources = null;
    $(document).ready(function(){
            
            var span = document.getElementsByClassName("close")[0];
            var modal = document.getElementById('myModal');
            span.onclick = function() {
                
                modal.style.display = "none";
            };
            window.onclick = function(event) {
                
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };
            objResources = new jsResources();
            objResources.setHTML('<?php echo($_SESSION['spr']); ?>','<?php echo($_GET['token']); ?>','<?php echo($_SESSION['nme']); ?>',$('#divHeader'),$('#divFooter'), $('#divBreadcrumbs'), JSON.stringify([{'s':'home.php', 'n': 'inicio'},{'s':'#', 'n': 'ap / ao'},{'s':'#', 'n': 'árbol de objetivos'}]));
            getProjects();
        });
    
    function getProjects()
    {
        $.post('../business/bsnsTrees.php',{iC:1},function(f){
                objResources.ComboPopulate($('#cobProj'),f);
            });
                
    }
    
    function setJson()
    {
        var v = document.querySelectorAll('.boxWrapper');
        var u = [];
        var w = '';
        for(i=0; i< v.length; i++)
        {
            w = v[i].querySelector('[data-code]');
            if($(w).text())
            {
                u[i] = {key:$(w).data('code'), value: $(w).text()};
                v[i].classList.remove("boxTreeFix");
                v[i].classList.add("boxTreeAuto");
            }
        }
    }
    
    function cleanFields()
    {
        var v = document.querySelectorAll('.boxWrapper');
        //var u = [];
        var w = '';
        for(i=0; i< v.length; i++)
        {
            w = v[i].querySelector('[data-code]');
            $(w).text('');
            v[i].classList.remove("boxTreeAuto");
            v[i].classList.add("boxTreeFix");
           
            /*if($(w).text())
            {
                u[i] = {key:$(w).data('code'), value: $(w).text()};
                v[i].classList.remove("boxTreeFix");
                v[i].classList.add("boxTreeAuto");
            }*/
        }
    }

 function getDataTree(id)
 {
   cleanFields();
    $.post('../business/bsnsTrees.php',{iC: 2, arg1: id, arg2:  $('#lblProj').text()},function(f){
        var v = document.querySelectorAll('.boxWrapper');
        var w = '';
        $.each(jQuery.parseJSON(f),function(){
            for(i=0; i< v.length; i++)
            {
                w = v[i].querySelector('[data-code]');
                if(this.code == $(w).data('code'))
                {
                    $(w).text(this.value);
                    v[i].classList.remove("boxTreeFix");
                    v[i].classList.add("boxTreeAuto");
                }
            }
            });
        });
 }
    
    function myModalCall(x)
    {
  
    if($('#cobProj').val() !== '0' && $('#cobProj').val() !== null)
    {
        var v = x.querySelector('[data-code]');
        $('#txtCode').text($(v).data('code'));
        if($(v).text()){
         $('#txtData').val($(v).text());
        }
        else
        {
            $('#txtData').val('');
        }
        var modal = document.getElementById('myModal');
        modal.style.display = "block";
        $('#txtData').focus();
         }
    else
    {
        alert('Elige un proyecto...');
    }
        
    }
    
    function SaveModule(code)
    {
         
        var modal = document.getElementById('myModal');
        var v = document.querySelectorAll('.boxWrapper');
        var w = '';
        for(i=0; i< v.length; i++)
        {
            w = v[i].querySelector('[data-code]');
            if($(w).data('code') == code)
            {
                if($('#txtData').val().length == '0')
                {
                    v[i].classList.remove("boxTreeAuto");
                    v[i].classList.add("boxTreeFix");
                }
                else
                {
                    v[i].classList.remove("boxTreeFix");
                    v[i].classList.add("boxTreeAuto");
                }
                $(w).text($('#txtData').val());
                i = v.length;
            }
            
        }
        var d = {tree: $('#lblProj').text(), id: $('#cobProj').val(), key: code, value: $('#txtData').val(), user:'<?php echo($_SESSION['usr']); ?>'};
        modal.style.display = "none";
        $.post('../business/bsnsTrees.php',{iC:3, arg1: JSON.stringify(d)},function(){});
       
    }
    
    
</script>
<header class="w3-top">
    <div id="divHeader"></div>
</header>
<section class="w3-container" style="height: 100px;">
    <div id="myModal" class="modal">
    <div class="modal-content">
       
        <div class="modal-header">
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <p>Escribe algunas oraciones con las que identifiques este modulo.</p>
            <div class="w3-container">
                <h4 id="txtCode"></h4>
                <input id="txtData" class="w3-input" maxlength="1000" type="text">
            </div>
        </div>
        <br>
        <div class="modal-footer">
          <button onclick="SaveModule($('#txtCode').text());"  class="w3-button w3-indigo">Guardar...</button>
          <p class="w3-text-red"><span><strong>&#9873;</strong></span> Información obligatoria</p>
        </div>
        
    </div>
    </div>
</section>
<!--<section>
<div  class="w3-left w3-hover-opacity"><i class="fas fa-bars fa-lg" onclick="setJson();"></i></div>
</section>-->
<section class="w3-center">
    <select id="cobProj" class="w3-select" style="width: 60%;" onchange="getDataTree(this.value);" name="option"></select> 
    <br>
    <br>
    <label id="lblProj" class="w3-large">Árbol de objetivos</label>
</section>
<br>
<section class="divMiddle w3-center">
    <div class="w3-row">
        <div class="w3-container w3-quarter"></div>
        <div class="w3-container w3-half">
            <div class="w3-card-4 w3-margin w3-green boxTreeFix boxWrapper caran-hover-verde-full" onclick="myModalCall(this);" >
                <label>Fin último</label>
                <p data-code="Fin"></p>
            </div>
        </div>
        <div class="w3-container w3-quarter"></div>
    </div>
    <div class="w3-row">
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-green boxTreeFix boxWrapper caran-hover-verde-full" onclick="myModalCall(this);">
            <label>Fin</label>
            <p data-code="C2C1"></p>
            </div>
        </div>
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-green boxTreeFix boxWrapper caran-hover-verde-full" onclick="myModalCall(this);">
            <label>Fin</label>
            <p data-code="C2C2"></p>
            </div>
        </div>
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-green boxTreeFix boxWrapper caran-hover-verde-full" onclick="myModalCall(this);">
            <label>Fin</label>
            <p data-code="C2C3"></p>
            </div>
        </div>
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-green boxTreeFix boxWrapper caran-hover-verde-full" onclick="myModalCall(this);">
            <label>Fin</label>
            <p data-code="C2C4"></p>
            </div>
        </div>
    </div>
    <div class="w3-row">
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-green boxTreeFix boxWrapper caran-hover-verde-full" onclick="myModalCall(this);">
            <label>Fin</label>
            <p data-code="C1C1"></p>
            </div>
        </div>
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-green boxTreeFix boxWrapper caran-hover-verde-full" onclick="myModalCall(this);">
            <label>Fin</label>
            <p data-code="C1C2"></p>
            </div>
        </div>
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-green boxTreeFix boxWrapper caran-hover-verde-full" onclick="myModalCall(this);">
            <label>Fin</label>
            <p data-code="C1C3"></p>
            </div>
        </div>
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-green boxTreeFix boxWrapper caran-hover-verde-full" onclick="myModalCall(this);">
            <label>Fin</label>
            <p data-code="C1C4"></p>
            </div>
        </div>
    </div>
    <div class="w3-row">
        <div class="w3-container w3-quarter"></div>
        <div class="w3-container w3-half">
            <div class="w3-card-4 w3-margin w3-indigo boxTreeFix boxWrapper caran-hover-azul-full" onclick="myModalCall(this);">
            <label>Propósito</label>
            <p data-code="Propósito"></p>
            </div>
        </div>
        <div class="w3-container w3-quarter"></div>
    </div>
    <div class="w3-row">
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-red boxTreeFix boxWrapper caran-hover-rojo-full" onclick="myModalCall(this);">
            <label>Medio 1</label>
            <p data-code="C1"></p>
        </div>
        </div>
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-red boxTreeFix boxWrapper caran-hover-rojo-full" onclick="myModalCall(this);">
            <label>Medio 2</label>
            <p data-code="C2"></p>
            </div>
        </div>
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-red boxTreeFix boxWrapper caran-hover-rojo-full" onclick="myModalCall(this);">
            <label>Medio 3</label>
            <p data-code="C3"></p>
            </div>
        </div>
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-red boxTreeFix boxWrapper caran-hover-rojo-full" onclick="myModalCall(this);">
            <label>Medio 4</label>
            <p data-code="C4"></p>
            </div>
        </div>
    </div>
   
    <div class="w3-row">
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-yellow boxTreeFix boxWrapper caran-hover-amarillo-full" onclick="myModalCall(this);">
            <label>Actividad C1A1</label>
            <p data-code="C1A1"></p>
            </div>
        </div>
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-yellow boxTreeFix boxWrapper caran-hover-amarillo-full" onclick="myModalCall(this);">
            <label>Actividad C2A1</label>
            <p data-code="C2A1"></p>
            </div>
        </div>
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-yellow boxTreeFix boxWrapper caran-hover-amarillo-full" onclick="myModalCall(this);">
            <label>Actividad C3A1</label>
            <p data-code="C3A1"></p>
            </div>
        </div>
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-yellow boxTreeFix boxWrapper caran-hover-amarillo-full" onclick="myModalCall(this);">
            <label>Actividad C4A1</label>
            <p data-code="C4A1"></p>
            </div>
        </div>
    </div>
    <div class="w3-row">
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-yellow boxTreeFix boxWrapper caran-hover-amarillo-full" onclick="myModalCall(this);">
            <label>Actividad C1A2</label>
            <p data-code="C1A2"></p>
            </div>
        </div>
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-yellow boxTreeFix boxWrapper caran-hover-amarillo-full" onclick="myModalCall(this);">
            <label>Actividad C2A2</label>
            <p data-code="C2A2"></p>
            </div>
        </div>
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-yellow boxTreeFix boxWrapper caran-hover-amarillo-full" onclick="myModalCall(this);">
            <label>Actividad C3A2</label>
            <p data-code="C3A2"></p>
            </div>
        </div>
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-yellow boxTreeFix boxWrapper caran-hover-amarillo-full" onclick="myModalCall(this);">
            <label>Actividad C4A2</label>
            <p data-code="C4A2"></p>
            </div>
        </div>
    </div>
    <div class="w3-row">
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-yellow boxTreeFix boxWrapper caran-hover-amarillo-full" onclick="myModalCall(this);">
            <label>Actividad C1A3</label>
            <p data-code="C1A3"></p>
            </div>
        </div>
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-yellow boxTreeFix boxWrapper caran-hover-amarillo-full" onclick="myModalCall(this);">
            <label>Actividad C2A3</label>
            <p data-code="C2A3"></p>
            </div>
        </div>
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-yellow boxTreeFix boxWrapper caran-hover-amarillo-full" onclick="myModalCall(this);">
            <label>Actividad C3A3</label>
            <p data-code="C3A3"></p>
            </div>
        </div>
        <div class="w3-container w3-quarter">
            <div class="w3-card-4 w3-margin w3-yellow boxTreeFix boxWrapper caran-hover-amarillo-full" onclick="myModalCall(this);">
            <label>Actividad C4A3</label>
            <p data-code="C4A3"></p>
            </div>
        </div>
    </div>
</section>
<section class="w3-container" style="height: 100px;"></section>
<footer class="w3-container w3-padding-64 w3-center w3-opacity">
    <div id="divBreadcrumbs"></div>
  <div id="divFooter"></div>
</footer>
</body>
</html>
