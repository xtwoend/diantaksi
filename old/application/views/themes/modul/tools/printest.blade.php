@layout('themes.layouts.common')

@section('header')
  
  <div class="header">
        <h1 class="page-title">Schedule</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li class="active">Schedule</li>
    </ul>
@endsection
  
  
@section('content')

 
  <div id="content"><h1 id="title">QZ Print Plugin</h1></div><br /><br /><br />
  <table border="1px" cellpadding="5px" cellspacing="0px"><tr>

  <td valign="top"><h2>All Printers</h2>
  <input type="button" onClick="findPrinter()" value="Detect Printer"><br />
  <input id="printer" type="text" value="EpsonMini" size="15"><br />
  <?php 

  function left($str, $length) {
      return substr($str, 0, $length);
  }

  function right($str, $length) {
      return substr($str, -$length);
  }
  
  $data = array('HUTANG' => 200000 , 'MAKAN' => 40000, 'BERAX' => 200000 );
  
  $total = array('TOTAL' => 440000);


  function textFormat($arrayData, $maxchar)
  {
    $maxchar = 40;
    $text = '';
    foreach($arrayData as $key => $val){
      $newval = number_format( $val, 0, '', '.');

      $space = $maxchar - (strlen($key) + strlen($newval) + 2);

      $text .= left($key, strlen($key));
      $text .= str_repeat(" ", $space);
      $text .= right($newval, strlen($newval)); 
      $text .= ",-";
      $text .= ("\r\n");
    }
    return $text;
  }

  ?>

  </td><td valign="top"><h2>Raw Printers Only</h2>
<textarea id="textS" rows="30" style="width: 300px;">
Nama  : Maman Suryaman
Body  : A-001
Tanggal : <?php echo date('Y-m-d H:i:s'); ?> 
========================================
TAGIHAN HUTANG
----------------------------------------
<?php echo textFormat($data, 40); ?>
----------------------------------------
<?php echo textFormat($total, 40); ?>

</textarea>

  <button id="printok">PRINT</button>
  </tr></table>

<applet id="qz" archive="{{ URL::base() }}/qzprint/qz-print.jar" name="QZ Print Plugin" code="qz.PrintApplet.class" width="55" height="55">
  <param name="jnlp_href" value="{{ URL::base() }}/qzprint/qz-print_jnlp.jnlp">
  <param name="cache_option" value="plugin">
  <param name="disable_logging" value="false">
  <param name="initial_focus" value="false">
</applet>
@endsection

@section('otherscript')   

<script type="text/javascript">

  /**
  * Automatically gets called when applet has loaded.
  */
  function qzReady() {
    // Setup our global qz object
    window["qz"] = document.getElementById('qz');
    var title = document.getElementById("title");
    if (qz) {
      try {
        title.innerHTML = title.innerHTML + " " + qz.getVersion();
        document.getElementById("content").style.background = "#F0F0F0";
      } catch(err) { // LiveConnect error, display a detailed meesage
        document.getElementById("content").style.background = "#F5A9A9";
        alert("ERROR:  \nThe applet did not load correctly.  Communication to the " + 
          "applet has failed, likely caused by Java Security Settings.  \n\n" + 
          "CAUSE:  \nJava 7 update 25 and higher block LiveConnect calls " + 
          "once Oracle has marked that version as outdated, which " + 
          "is likely the cause.  \n\nSOLUTION:  \n  1. Update Java to the latest " + 
          "Java version \n          (or)\n  2. Lower the security " + 
          "settings from the Java Control Panel.");
      }
    }
  }
  
  /**
  * Returns whether or not the applet is not ready to print.
  * Displays an alert if not ready.
  */
  function notReady() {
    // If applet is not loaded, display an error.
    if (!qz) {
      alert('Error:\n\n\tApplet is not loaded!');
      return true;
    } 
      // If a printer hasn't been selected, display a message.
    else if (!qz.getPrinter()) {
      alert('Please select a printer first by using the "Detect Printer" button.');
      return true;
    }
    return false;
  }
  
  /**
  * Automatically gets called when "qz.print()" is finished.
  */
  function qzDonePrinting() {
    // Alert error, if any
    if (qz.getException()) {
      alert('Error printing:\n\n\t' + qz.getException().getLocalizedMessage());
      qz.clearException();
      return; 
    }
    
    // Alert success message
    alert('Successfully sent print data to "' + qz.getPrinter() + '" queue.');
  }
  

  /***************************************************************************
  * *                          PRINT OK                                   **
  ***************************************************************************/
  

  function findPrinter(name) {
    // Get printer name from input box
    var p = document.getElementById('printer');
    if (name) {
      p.value = name;
    }
    if (qz) {
      // Searches for locally installed printer with specified name
      qz.findPrinter(p.value);
    } else {
      // If applet is not loaded, display an error.
      return alert('Error:\n\n\tApplet is not loaded!');
    }
     
    // Automatically gets called when "qz.findPrinter()" is finished.
    window['qzDoneFinding'] = function() {
        var p = document.getElementById('printer');
      var printer = qz.getPrinter();
      
      // Alert the printer name to user
        alert(printer !== null ? 'Printer found: "' + printer + 
        '" after searching for "' + p.value + '"' : 'Printer "' + 
        p.value + '" not found.');
      
      // Remove reference to this function
      window['qzDoneFinding'] = null;
    };
  }
  
  $('#printok').live('click', function(){

    printnow($('#textS').val());

    return false;
  });

  function printnow(str){
    if (notReady()) { return; }
    str = returnEnter(str); 
    /* header */
    qz.append("\x1B\x40"); // 1 INITIAL PRINTER 
    qz.append("\x1B\x61\x01"); // 1 SET CENTER PAGE
    qz.append("\x1B\x21\x17");
    qz.append("TANDA TERIMA SETORAN \r\n"); 
    qz.append("\x1B\x21");
    qz.appendHex("x00"); //bug \x00
    qz.append("\x1B\x40"); // 1 RESET
    qz.append("\x1B\x61\x01"); // 1 SET CENTER PAGE
    qz.append("PT. DHARMA INDAH AGUNG METROPOLITAN \r\n");
    qz.append("POOL DIAN A \r\n");
    qz.append("======================================== \r\n"); 
    qz.append("\x1B\x61"); // 1 SET LEFT PAGE 
    qz.appendHex("x00"); //bug \x00
    qz.append(str);
    qz.append("\x1D\x56\x41"); // 4 motong kertas
    qz.append("\x1B\x40"); // 5 END 
    qz.print();
  }  

  /***************************************************************************
  * *                          HELPER FUNCTIONS                             **
  ***************************************************************************/

  /**
  * Fixes some html formatting for printing. Only use on text, not on tags!
  * Very important!
  *   1.  HTML ignores white spaces, this fixes that
  *   2.  The right quotation mark breaks PostScript print formatting
  *   3.  The hyphen/dash autoflows and breaks formatting  
  */
  function fixHTML(html) {
    return html.replace(/ /g, "&nbsp;").replace(/’/g, "'").replace(/-/g,"&#8209;"); 
  }
  
  /**
  * Equivelant of VisualBasic CHR() function
  */
  function chr(i) {
    return String.fromCharCode(i);
  }
  
  function returnEnter(dataStr)
  {
    return dataStr.replace(/(\r\n|\r|\n)/g, "\n");
  }

  
</script>
@endsection
