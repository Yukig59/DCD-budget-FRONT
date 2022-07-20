window.hide = function hide(elementId) {
    let myElement = document.getElementById(elementId);
    if (myElement) myElement.style.display = "none";
}
window.active = function active(elementId){
    document.getElementById(elementId).classList.add('has-background-primary')
}
window.desactive =function desactive(elementId){
    document.getElementById(elementId).classList.remove('has-background-primary')
}
window.show = function show(elementId) {
    switch (elementId) {
        case "market":
            hide('user');
            hide('fournisseur');
            document.getElementById("market").style.display = "block";
            active('showMarket')
            desactive('showUser')
            desactive('showFourn')
            break;
        case "user":
            hide('market');
            hide('fournisseur');
            document.getElementById("user").style.display = "block";
            active('showUser')
            desactive('showMarket')
            desactive('showFourn')
            break;
        case "fournisseur":
            hide('market');
            hide('user');
            document.getElementById("fournisseur").style.display = "block";
            desactive('showUser')
            desactive('showMarket')
            active('showFourn')
            break;
    }
}

window.exports =  {hide:hide(), active:active(), show:show()}