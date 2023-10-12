<?php
if($level==3){
    
echo '
<nav class="menu-lateral">
<ul>
    <li class="item-menu">
        <a href="index.php">
            <span class="icon"><i class="bi bi-house"></i></span>
            <span class="txt-link">HOME</span>
        </a>
    </li>';

        if($level==3){
            include ('menuLateral/itemPedidos.php');
            include ('menuLateral/itemCadastro.php');
            include ('menuLateral/itemRel.php');
            include ('menuLateral/itemEstoque.php');

        }else if($level==2){
            include ('menuLateral/itemPedidos.php');
            include ('menuLateral/itemCadastro.php');

        }else if ($level==1){
            include ('menuLateral/itemPedidos.php');

        };
       echo' <li class="item-menu">
        <a href="logout.php">
            <span class="icon"><i class="bi bi-arrow-bar-left"></i></span>
            <span class="txt-link">SAIR</span>
        </a>
    </li>';
    
'</ul>
</nav>';


/*echo '
<div class="navSup">
<button class="btnLogOut" onclick="window.location.href=\'logout.php\'">Sair</button>
</div>

';*/

}else if($level==2){
        
echo '
<nav class="menu-lateral2">
<ul>
    <li class="item-menu">
        <a href="index.php">
            <span class="icon"><i class="bi bi-house"></i></span>
            <span class="txt-link">HOME</span>
        </a>
    </li>';

        if($level==3){
            include ('menuLateral/itemPedidos.php');
            include ('menuLateral/itemCadastro.php');
            include ('menuLateral/itemRel.php');
            include ('menuLateral/itemEstoque.php');

        }else if($level==2){
            include ('menuLateral/itemPedidos.php');
            include ('menuLateral/itemCadastro.php');

        }else if ($level==1){
            include ('menuLateral/itemPedidos.php');

        };
    
'</ul>
</nav>';


echo '
<div class="navSup">
<button class="btnLogOut" onclick="window.location.href=\'logout.php\'">Sair</button>
</div>

';


}else if($level==1){
        
echo '
<nav class="menu-lateral1">
<ul>
    <li class="item-menu">
        <a href="index.php">
            <span class="icon"><i class="bi bi-house"></i></span>
            <span class="txt-link">HOME</span>
        </a>
    </li>';

        if($level==3){
            include ('menuLateral/itemPedidos.php');
            include ('menuLateral/itemCadastro.php');
            include ('menuLateral/itemRel.php');
            include ('menuLateral/itemEstoque.php');

        }else if($level==2){
            include ('menuLateral/itemPedidos.php');
            include ('menuLateral/itemCadastro.php');

        }else if ($level==1){
            include ('menuLateral/itemPedidos.php');

        };
    
'</ul>
</nav>';


echo '
<div class="navSup">
<button class="btnLogOut" onclick="window.location.href=\'logout.php\'">Sair</button>
</div>

';

}
    
    

?>