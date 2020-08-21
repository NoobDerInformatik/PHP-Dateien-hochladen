<!DOCTYPE html>
<html>
      <form action="index.php" method="POST" enctype="multipart/form-data">
          Datei auswählen: <input name="userfile" type="file"/><br>
          <input type="submit" name="submit" value="Send File"/>
      </form>
</html>

<?php
if(isset($_POST['submit'])){              //Wenn der Button gedrückt wird
    $file = $_FILES['userfile'];

    $filename = $file['name'];            //Informationen auslesen
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $filename);                                 //Name aufteilen in Name und Dateiendung
    $fileActualExt = strtolower(end($fileExt));                         //Dateiendung kleinschreiben für besseren Vergleich

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');                      //Dateiendungen die erlaubt sind
    if(in_array($fileActualExt, $allowed)){                             //Schauen ob die Dateiendung erlaubt ist
        if($fileError === 0){
            if($fileSize < 500000){                                     //500.000kb = 500mb
                $fileNameNew = uniqid('', true).".".$fileActualExt;     //Eindeutiger Name vergeben
                $fileDestination = 'web/'.$fileNameNew;                 //Wohin es geladen werden soll
                move_uploaded_file($fileTmpName, $fileDestination);     //Vom temporären zum Ziel verschieben
                echo "Erfolgreich hochgeladen";
            }else{
                echo "Die Datei ist zu groß!";
            }
        }else{
            echo "Es gab einen Fehler beim Hochladen!";
        }
    }else{
        echo "Du kannst Dateien mit dieser Endung nicht hochladen!";
    }
}else{
?>
