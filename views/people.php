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
<link href="../images/favicon.png" rel="icon" />
<link href="../styles/cssW3.css" rel="stylesheet" />
<link href="../styles/cssTemplate.css" rel="stylesheet" />
</head>
<body>
<script src="../scripts/jquery.min.js"></script>
<script src="../scripts/jsResources.js"></script>
<script src="../scripts/jsFa.min.js"></script>
<script>
    var objResources = null;
    $(document).ready(function(){
            objResources = new jsResources();
            
            
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
            
            
            objResources.setHTML('<?php echo($_SESSION['spr']); ?>','<?php echo($_GET['token']); ?>','<?php echo($_SESSION['nme']); ?>',$('#divHeader'),$('#divFooter'), $('#divBreadcrumbs'), JSON.stringify([{'s':'home.php', 'n': 'inicio'},{'s':'#', 'n': 'involucrados'}, {'s':'#', 'n': 'análisis'}]));
            getProjects();
        });
    
    function getProjects()
    {
        $.post('../business/bsnsTrees.php',{iC:1},function(f){
                objResources.ComboPopulate($('#cobProj'),f);
            });
                
    }
    
    function EditModule(id, people, group, dom)
    {
        $.post('../business/bsnsPeople.php',{iC:4, arg1: id, arg2:people, arg3:group, arg4:dom.substring(dom.length-1)},function(){
                var modal = document.getElementById('myModal');
                modal.style.display = "none";
                $('#'+dom).text('CARAN SC').toggleClass('w3-text-white',true);
            });
    }
    
    function SaveModule(id, people, group, dom)
    {
        $.post('../business/bsnsPeople.php',{iC:1, arg1: id, arg2:people, arg3:group, arg4:dom.substring(dom.length-1)},function(){
                var modal = document.getElementById('myModal');
                modal.style.display = "none";
                $('#'+dom).text(people).toggleClass('w3-text-white',false);
            });
    }
    
    function getDataPeople(id)
    {
        $.post('../business/bsnsPeople.php',{iC:2, arg1:id},function(f){
            $.each(jQuery.parseJSON(f), function() {
                    $('#lbl'+this.L2+''+this.L3).text(this.L1).toggleClass('w3-text-white',false);
                });
        });
    }
    
function myModalCall(id, group)
    {
        if($('#cobProj').val() !== '0' && $('#cobProj').val() !== null)
        {
            var modal = document.getElementById('myModal');
            modal.style.display = "block";
            $('#txtCode').text(group);
            $('#txtDOM').text(id);
            if($('#'+id).text() == 'CARAN SC')
            {
                $('#txtData').val('').focus();
            }
            else
            {
                $('#txtData').val($('#'+id).text()).focus();
            }
        }
        else
        {
            alert('Elige un proyecto...');
        }
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
            <p>Escribe los actores mas relevantes de tu proyecto.</p>
            <div class="w3-container">
                <h4 id="txtCode"></h4>
                <h4 id="txtDOM" class="w3-hide"></h4>
                <input id="txtData" class="w3-input"  maxlength="1000" type="text">
            </div>
        </div>
        <br>
        <div class="modal-footer">
            <button onclick="SaveModule($('#cobProj').val(),$('#txtData').val(),$('#txtCode').text(),$('#txtDOM').text());"  class="w3-button w3-indigo">Guardar...</button>
            <button onclick="EditModule($('#cobProj').val(),$('#txtData').val(),$('#txtCode').text(),$('#txtDOM').text());"  class="w3-button w3-green">Borrar...</button>
            <!--<p class="w3-text-red"><span><strong>&#9873;</strong></span> Información obligatoria</p>-->
        </div>
        
    </div>
    </div>
</section>
<section class="w3-center">
    <select id="cobProj" class="w3-select" style="width: 60%;" onchange="getDataPeople(this.value);" name="option"></select> 
    <br>
    <br>
    <label id="lblProj" class="w3-large">Análisis de involucrados</label>
</section>
<br>
<section class="w3-container w3-center">
    <div class="w3-row-padding">
        <div class="w3-quarter"><img src="../images/_act_1.png" alt="actores directos" /></div>
        <div class="w3-quarter"><img src="../images/_act_2.png" alt="actores indirectos" /></div>
        <div class="w3-quarter"><img src="../images/_act_3.png" alt="actores neutros" /></div>
        <div class="w3-quarter"><img src="../images/_act_4.png" alt="actores externos" /></div>
    </div>
    <br>
    <div class="w3-row-padding">
        <div class="w3-quarter caran-azul-xxh"><h5>Directos</h5></div>
        <div class="w3-quarter caran-azul-xh"><h5>Indirectos</h5></div>
        <div class="w3-quarter caran-azul-h"><h5>Neutros</h5></div>
        <div class="w3-quarter caran-azul-m"><h5>Externos</h5></div>
    </div>
    <div class="w3-row-padding">
        <div id="lblDirectos1" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Directos');">CARAN SC</div>
        <div id="lblIndirectos1" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Indirectos');">CARAN SC</div>
        <div id="lblNeutros1" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Neutros');">CARAN SC</div>
        <div id="lblExternos1" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Externos');">CARAN SC</div>
    </div>
    <div class="w3-row-padding">
        <div id="lblDirectos2" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Directos');">CARAN SC</div>
        <div id="lblIndirectos2" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Indirectos');">CARAN SC</div>
        <div id="lblNeutros2" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Neutros');">CARAN SC</div>
        <div id="lblExternos2" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Externos');">CARAN SC</div>
    </div>
    <div class="w3-row-padding">
        <div id="lblDirectos3" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Directos');">CARAN SC</div>
        <div id="lblIndirectos3" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Indirectos');">CARAN SC</div>
        <div id="lblNeutros3" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Neutros');">CARAN SC</div>
        <div id="lblExternos3" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Externos');">CARAN SC</div>
    </div>
    <div class="w3-row-padding">
        <div id="lblDirectos4" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Directos');">CARAN SC</div>
        <div id="lblIndirectos4" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Indirectos');">CARAN SC</div>
        <div id="lblNeutros4" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Neutros');">CARAN SC</div>
        <div id="lblExternos4" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Externos');">CARAN SC</div>
    </div>
    <div class="w3-row-padding">
        <div id="lblDirectos5" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Directos');">CARAN SC</div>
        <div id="lblIndirectos5" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Indirectos');">CARAN SC</div>
        <div id="lblNeutros5" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Neutros');">CARAN SC</div>
        <div id="lblExternos5" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Externos');">CARAN SC</div>
    </div>
    <div class="w3-row-padding">
        <div id="lblDirectos6" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Directos');">CARAN SC</div>
        <div id="lblIndirectos6" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Indirectos');">CARAN SC</div>
        <div id="lblNeutros6" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Neutros');">CARAN SC</div>
        <div id="lblExternos6" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'Externos');">CARAN SC</div>
    </div>    
</section>
<!--<section class="w3-container" style="height: 200px;"></section>-->
<footer class="w3-container w3-padding-64 w3-center w3-opacity">
    <div id="divBreadcrumbs"></div>
    <div id="divFooter"></div>
</footer>
</body>
</html>
