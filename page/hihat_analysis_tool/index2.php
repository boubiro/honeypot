<?php


/* This file is part of HIHAT v1.1
   ================================
   Copyright (c) 2007 HIHAT-Project                   
  
  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.
  
  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.
  
  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 
*/

    error_reporting(E_ALL);
    include "inc/config.php"; // die Konfigurationsdateien lesen.
set_time_limit( 180 );

    // Verbindung zu MySQL Aufbauen
    $conn = @mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, 'ip2location') OR die(mysqli_error($conn));
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n";
    echo "         \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n";
    echo "<html>\n";
    echo "    <head>\n";
    echo "        <title>HIHAT</title>\n";
    echo "        <link rel=\"stylesheet\" type=\"text/css\" href=\"page.css\" />\n";
    echo "        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\" />\n";
    echo "    </head>\n";
    echo "    <body>\n";
    
    echo "            <div id=\"links\">\n"; // linkes Menu
    include "menu.php";
    echo "            </div>\n";
    echo "            <div id=\"mitte\">\n"; // In der Mitte der Inhalt
    
    function LongIP2int ($IPaddr){
    if ($IPaddr == "") {
        return 0;
    } else {
        $ips = split ("\.", "$IPaddr");
        return ($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256);
    }
}
function BigInt2ip( $bigint ){
    return ((int)( $bigint / 16777216 ) % 256).".".((int)( $bigint / 65536 ) % 256).".".
            ((int)( $bigint / 256 ) % 256).".".((int)(( $bigint ) % 256)+256);            
}



	// change to your honeypot IP
    $sql = "SELECT
                *
            FROM
                ip2location
            WHERE
                (ipFROM <= ".LongIP2int('127.0.0.1').") AND (ipTO >= ".LongIP2int('127.0.0.1').")
           
           "; echo $sql." ".LongIP2int('127.0.0.1')." ".BigInt2ip( 225836673 ); 
           
    $result = mysqli_query($conn, $sql) OR die(mysqli_error($conn));
    $output = ""; 
    if(mysqli_num_rows($result)) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $output .=  $row['countryLONG']." ".$row['ipCITY']."<br>";
            
        }
    } else {
        $output .= "<p>No data found</p>\n";
    }
    echo $output;

//include "inhalt.php";
    
    
    
    echo "            </div>\n";
    echo "            <br style=\"clear:both;\" />\n"; // css-float beenden
    echo "       </div>\n";

    echo "    </body>\n";
    echo "</html>\n";
?>
