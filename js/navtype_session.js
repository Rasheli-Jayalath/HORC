    var NAVTYPE = sessionStorage.getItem('NAVTYPE');

    if(NAVTYPE=='HORZNAV')
    {
         //alert(NAVTYPE);

        document.getElementById("navbarburgericon").style.display="none";
        document.getElementById("horizontalnavbar").style.display="block";
        document.getElementById("pagebodywraper").style.marginTop="55px";
        document.getElementById("partials-sidebar-offcanvas").style.display="none";
        document.getElementById("mainpanel").style.width="100%";
    }
    else if(NAVTYPE=='VERTNAV')
    {
        //alert(NAVTYPE);

        document.getElementById("navbarburgericon").style.display="block";
        document.getElementById("horizontalnavbar").style.display="none";
         document.getElementById("pagebodywraper").style.marginTop="0px";
        document.getElementById("partials-sidebar-offcanvas").style.display="block";
         document.getElementById("mainpanel").style.width="calc(100% - 220px)";
         document.getElementById("mainpanel").style.display="flex";
    }

