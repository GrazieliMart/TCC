<?php
if ($level == 3) {
    echo '
<nav class="menu-lateral">
<ul>
    <li class="item-menu">
        <a href="index.php">
            <span class="icon"><i class="bi bi-house"></i></span>
            <span class="txt-link">HOME</span>
        </a>
    </li>';

        include('menuLateral/itemPedidos.php');
        include('menuLateral/itemCadastro.php');
        include('menuLateral/itemRel.php');
        include('menuLateral/itemEstoque.php');

    echo ' <li class="item-menu">
        <a href="logout.php">
            <span class="icon"><i class="bi bi-arrow-bar-left"></i></span>
            <span class="txt-link">SAIR</span>
        </a>
    </li>
    </ul>
</nav>';


} else if ($level == 2) {

    echo '
<nav class="menu-lateral2">
<ul>
    <li class="item-menu">
        <a href="index.php">
            <span class="icon"><i class="bi bi-house"></i></span>
            <span class="txt-link">HOME</span>
        </a>
    </li>';

        include('menuLateral/itemPedidos.php');
        include('menuLateral/itemCadastro.php');

    echo ' <li class="item-menu">
        <a href="logout.php">
            <span class="icon"><i class="bi bi-arrow-bar-left"></i></span>
            <span class="txt-link">SAIR</span>
        </a>
    </li>
    </ul>
</nav>';




} else if ($level == 1) {

    echo '
<nav class="menu-lateral1">
<ul>
    <li class="item-menu">
        <a href="index.php">
            <span class="icon"><i class="bi bi-house"></i></span>
            <span class="txt-link">HOME</span>
        </a>
    </li>';

  
        include('menuLateral/itemPedidos.php');

    
    
    echo ' <li class="item-menu">
        <a href="logout.php">
            <span class="icon"><i class="bi bi-arrow-bar-left"></i></span>
            <span class="txt-link">SAIR</span>
        </a>
    </li>

    </ul>
</nav>';

}

?>