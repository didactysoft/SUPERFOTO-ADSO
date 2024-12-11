<html> 
 <head> 
  <script language="JavaScript"> 

   function abreSinNavegacion(){ 
    open('trabajos_entregados.php', 'principal', 'location=no,menubar=no,status=no,toolbar=no'); 
    cerrar(); 
   } 

   function cerrar() { 
    var ventana = window.self; 
    ventana.opener = window.self; 
    ventana.close(); 
   } 

  </script> 
 </head> 
 <body onload="abreSinNavegacion()"> 
 </body> 
</html> 