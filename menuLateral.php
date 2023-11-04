<?php
if ($level == 3) {
   
    echo '
    <div id="overlay"></div>

  <div class="menu-toggle" id="menuToggle">
<i class="bi bi-list"></i>

</div>

<nav class="menu-lateral"  id="menuLateral">


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
    
  
<nav class="menu-lateral2"  id="menuLateral2">
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
    
  
<nav class="menu-lateral1"  id="menuLateral1">
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
<script>
let isNavOpen = false; // Inicialmente, a navegação está fechada
document.addEventListener("DOMContentLoaded", function() { 
    const overlay = document.getElementById("overlay");
    const menuToggle = document.getElementById("menuToggle");
    const menu = document.querySelector(".menu-lateral");
   

    if (menuToggle) {
        menuToggle.addEventListener("click", function() {
            // Alternar a classe "active" na navegação
            if (isNavOpen) {
                overlay.style.display = 'none';
                menu.classList.remove("active");
            } else {
                menu.classList.add("active");
                 overlay.style.display = 'block';
            }
            isNavOpen = !isNavOpen; // Alternar o estado
        });
    }
});
</script>
