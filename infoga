<?php

// INPUT NOMER
$input = "62895636602176";
$caknomer = str_split($input);
// INISIALISASI NOMER PER FORMAT
$lokalformat = $input;
$interformat = "+".$input;
$rawformat = "0".$caknomer[2].$caknomer[3].$caknomer[4].$caknomer[5].$caknomer[6].$caknomer[7].$caknomer[8].$caknomer[9].$caknomer[10].$caknomer[11].$caknomer[12].$caknomer[13];
$spasiformat = "0".$caknomer[2].$caknomer[3].$caknomer[4]." ".$caknomer[5].$caknomer[6].$caknomer[7].$caknomer[8]." ".$caknomer[9].$caknomer[10].$caknomer[11].$caknomer[12].$caknomer[13];
$garisformat = "0".$caknomer[2].$caknomer[3].$caknomer[4]."-".$caknomer[5].$caknomer[6].$caknomer[7].$caknomer[8]."-".$caknomer[9].$caknomer[10].$caknomer[11].$caknomer[12].$caknomer[13];
$phogageneral1 = ("https://www.google.com/search?q=intext%3A%22".$lokalformat."%22+OR+intext%3A%22%2B".$lokalformat."%22+OR+intext%3A%22".$rawformat."%22+OR+intext%3A%22".$spasiformat."%22+OR+intext%3A%22".$garisformat."%22");

print_r("# Format 62 = ".$lokalformat."\n# Format +62 = ".$interformat."\n# Format 08 = ".$rawformat."\n# Format Bagi 4 = ".$spasiformat."\n# Format Garis = ".$garisformat."\n");

// GENERATE LINK
print_r("General Link 1:\n".$phogageneral1)."\n";
?>
