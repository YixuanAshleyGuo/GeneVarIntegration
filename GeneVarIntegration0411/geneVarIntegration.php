<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <title>GeneVarIntegration</title>
    <script   src="https://code.jquery.com/jquery-1.10.2.min.js"   ></script>

</head>    
    <body>
    <div id="maincontent">
        <div class="sideicon">
            <ul>
                <li>
                    <a href="http://www.ncbi.nlm.nih.gov/clinvar/">
                    <img src="images/projects/logo_clinvar.png">
                    </a>
                </li>
                <li>
                    <a href="http://annovar.openbioinformatics.org/en/latest/">
                    <img src="images/projects/logo_wannovar.png">
                    </a>
                </li>
                <li>
                    <a href="https://www.acmg.net/">
                    <img src="images/projects/logo_ACMG.jpg">
                    </a>
                </li>
                <li>
                    <a href="https://github.com/YixuanAshleyGuo/GeneVarIntegration/">
                    <div id="githubs">
                <svg viewBox="0 0 18 18" class="icon" style="fill:#7b0099; height:80px">
                    <use xlink:href="#github"></use>
                    </svg>
                    </div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="bodymain">
            <div class = "bodymain_head"><img src="images/projects/logo_columbia.png">
            <h2><a href="http://cri.dbmi.columbia.edu:10080/geneVarIntegration.php">Gene Variation UI</a></h2>
            </div>
            <p>Jan. 2016 - present</p>
            <p>Gene Variation UI is designed to incorporate the <a href="http://www.ncbi.nlm.nih.gov/clinvar/">ClinVar</a>, <a href="http://annovar.openbioinformatics.org/en/latest/">ANNOVAR</a> and <a href="https://www.acmg.net/">ACMG</a> database and present a integrated gene variation search tool for physicians.</p>
            <p><b>Author:</b> <a href="index.html">Yixuan Guo</a>, <a href="https://www.dbmi.columbia.edu/people/alexander-hsieh/">Alexander L. Hsieh</a>, <a href="https://www.dbmi.columbia.edu/people/chunhua-weng/">Chunhua Weng</a>, <a href="https://www.dbmi.columbia.edu/people/yufeng-shen/">Yufeng Shen</a>. <br><a href="http://www.cumc.columbia.edu/"><b>Columbia University Medical Center</b>.<br></a> <a href="https://www.dbmi.columbia.edu/">Department of Biomedical Informatics</a>.</p>
            <p>Updated: 04/11/2016</p>
            <p>Email <i>yg2430@columbia.edu</i> if you have any suggestions!</p>
        </div>
            <?php 
                    require"setup.php";
                    function start_view(){
                    print "
                    <center>
                    <h2> Query options</h2>

                    <input type=submit name=gene_query value=\"Query with Gene Symbol\"/>
                    <input type=submit name=allele_query value=\"Query with Allele Information\"/>
                    <input type=submit name=rsid_query value=\"Query with RSID Information\"/>
                    <br/><br/><br/>
                    </center>
                    ";
                    //                    <input type=submit name=suggestion value=\"Suggestion Box\"/>
                }
                function gene_query(){
                    print"
                    <center>
                        
                        <table id=\"query_tbl\">
                        <tr>
                        <th>Gene Symbol</th>
                        <th>Amino Acid Change</th>
                
                        </tr>
                        <tr>
                        <td><input type=text name=gene_name></td>
                        <td><input type=text name=animo_change></td>
                        
                        </tr>
                        </table>
                        <br/>
                        <input type=submit name=go_query value=Go!> 
                    </center>
                    <br><br><br>
                    ";
                    require("setup.php");                                       
                    $connect=mysql_connect($DB_SERVER.(isset($DB_PORT)?(':'.$DB_PORT):''),$DB_USER,$DB_PASS)or die("Link failed!");                           $db=mysql_select_db($DB_NAME,$connect)or die("sql failed!");
                    $sql = "select distinct(Gene_refGene) from $ANNOVAR";
                    $query = mysql_query($sql,$connect) or die("query failed!");
                    //no result turns out
                    if(($list = mysql_fetch_array($query)) === ""){
                        print"<p>There is no information in the ANNOVAR database, please check the database setup.</p>";
                    }
                    else{
                        print "
                        <h3 class=\"test_button\" style=\"position:fixed;display:inline-block;right:20px;bottom:300px\"><input type=submit name=go_test value=\"Go test\"></h3>
                        <center>
                        <table id = \"test_tbl\">
                        <tr>
                        <th colspan=5>Gene name</th>
                        </tr>
                        ";
                        print "
                        <tr>
                        <td><input type=\"radio\" name=\"gene_test\" value=$list[Gene_refGene] checked=\"checked\">$list[Gene_refGene]</td>
                        ";
                        $i = 1;
                        while($list = mysql_fetch_array($query)){
                            if($i %3 === 0){
                                print"<tr>";
                            }
                            print "
                            <td><input type=\"radio\" name=\"gene_test\" value=$list[Gene_refGene]>$list[Gene_refGene]</td>
                            ";
                            if($i %3 === 2){
                                print"<td>";
                            }
                            $i ++;
                        };
                        print "
                        </table>
                        <center>
                        <br><br><br>
                        ";
                    }
                    
                }
                function allele_query(){
                    print"
                    <center>
                        
                        <table id=\"query_tbl\">
                        <tr>
                        <th>Chromosome name</th>
                        <th>Variation start</th>
                        <th>Variation end</th>
                        <th>Ref</th>
                        <th>Alt</th>
                        </tr>
                        <tr>
                        <td><input type=text name=chr_name></td>
                        <td><input type=text name=var_start></td>
                        <td><input type=text name=var_end></td>
                        <td><input type=text name=gene_ref></td>
                        <td><input type=text name=gene_alt></td>
                        </tr>
                        </table>
                        <br/>
                        <input type=submit name=go_query value=Go!> 
                    </center>
                    ";
                }
                function rsid_query(){
                    print"
                    <center>
                        
                        <table id=\"query_tbl\">
                        <tr>
                        <th>RSID</th>
                        <th>Amino Acid Change</th>
                        </tr>
                        <tr>
                        <td><input type=text name=rsid></td>
                        <td><input type=text name=animo_change></td>
                        </tr>
                        </table>
                        <br/>
                        <input type=submit name=go_query value=Go!> 
                    </center>
                    ";            
                }
//                function suggestion_box(){
//                print
//}
                function add_star(&$disease,&$disease_db,&$clin_revstatus,&$pathogenicity){
                    $disease        .= '*************<br>';
                    $disease_db     .= '*************<br>';
                    $clin_revstatus .= '*************<br>';
                    $pathogenicity  .= '*************<br>';
                }
                function add_stroke(&$disease,&$disease_db,&$clin_revstatus,&$pathogenicity){
                    $disease        .= '-------------------------<br>';
                    $disease_db     .= '-------------------------<br>';
                    $clin_revstatus .= '-------------------------<br>';
                    $pathogenicity  .= '-------------------------<br>';
                }
                function add_content(&$disease,&$disease_db,&$clin_revstatus,&$pathogenicity,$disease_in,$disease_db_in,$disease_db_acc_in,$clin_revstatus_in,$pathogenicity_in){
                        $url="#";
                        if($disease_db_in === "OMIM"){
                            $url = "http://omim.org/entry/$disease_db_acc_in";
                        }
                        else if($disease_db_in === "MedGen"){
                            $url = "http://www.ncbi.nlm.nih.gov/medgen/?term=$disease_db_acc_in";
                        }
                        else if($disease_db_in === "Orphanet"){
                            $url = "http://www.orpha.net/consor/cgi-bin/index.php?lng=EN";
                        }
                        else if($disease_db_in === "SNOMED_CT"){
                            $url = "https://www.nlm.nih.gov/healthit/snomedct/index.html";
                        }
                        else if($disease_db_in === "GeneReviews"){
                            $url = "http://www.ncbi.nlm.nih.gov/books/$disease_db_acc_in";
                        }
                        
                        $disease_db .= "$disease_db_in:<a href = $url> $disease_db_acc_in</a><br>";
                        $disease .= "$disease_in<br>";
                        $clin_revstatus .= "$clin_revstatus_in<br>";
                        $pathogenicity .= "$pathogenicity_in<br>";
                }
                
                function query_view($gene_name,$chr_name,$var_start,$var_end,$rsid,$gene_ref,$gene_alt,$animo_change){      
                    //no valid input
                    if($chr_name==""&& $rsid==""&& $gene_name==""){
                        print "<p id=\"display_view\"><th><center>ATTENTION: Please enter valid the <b>chromosome name</b> or <b>Gene Variation</b> information!</center></th></p>";
//    echo "<certer><br><form><input type=button value=\"Back to previous\"onclick=\"history.back();\"></form>";
//    echo "<br></center>";
	                    exit;
                    }  

                    require("setup.php");                                       
                    $connect=mysql_connect($DB_SERVER.(isset($DB_PORT)?(':'.$DB_PORT):''),$DB_USER,$DB_PASS)or die("Link failed!");                                    
                    $db=mysql_select_db($DB_NAME,$connect)or die("sql failed!");


                    $sqla = "select * from $ANNOVAR where";
                    $sqla_tmp = "";
                    if($chr_name != ""){
                        $sqla_tmp .= " and $ANNOVAR.Chr = $chr_name";
                    }
                    else if($rsid != ""){
                        $rsid = "rs" .$rsid;
                        $sqla_tmp.= " and $ANNOVAR.rsid = '$rsid'";
                    }
                    else{
                        $sqla_tmp.= " and $ANNOVAR.Gene_refGene like '%$gene_name%'";
                    }
                    if($var_start != ""){
                        $sqla_tmp .= " and $ANNOVAR.START = $var_start";
                    }
                    if($var_end != ""){
                        $sqla_tmp .= " and $ANNOVAR.END = $var_end";
                    }
                    if($gene_ref != ""){
                        $sqla_tmp .= " and $ANNOVAR.Ref = $gene_ref";
                    }
                    if($gene_alt != ""){
                        $sqla_tmp .= " and $ANNOVAR.Alt = $gene_alt";
                    }
                    if($animo_change != ""){
                        $sqla_tmp .= " and $ANNOVAR.AACHANGE_refGene like '%$animo_change'";
                    }
                    $sqla .= substr($sqla_tmp,4);
                    $querya = mysql_query($sqla,$connect) or die("query failed!");
                    //no result turns out
                    if(($lista = mysql_fetch_array($querya)) === ""){
                        print"<p>There is no match between your gene variation and the database, please check your input information or <a href=\"http://www.ncbi.nlm.nih.gov/clinvar/docs/submit/\">report a new gene variation</a></p>";
                    }
                    else{             
                    print"<table id=\"query_tbl\"><tr>Gene Variation Information</tr>
                    <tr>
                    <th>Gene Name</th>
                    <th>Amino Acid Change</th>
                    <th>Disease</th>                    
                    <th>Disease Database</th>                    
                    <th>Pathogenicity</th>
                    <th>Revision Status</th>
                    <th>Gene Function</th>
                    <th>ExonicFunc_refGene</th>
                    <th>ACMG hit</th>
                    </tr>";
                    //fetch the results recursively
                    do{
                    $sqlc = "select * from $CLINVAR where $CLINVAR.RowID = $lista[RowID]";
                    $queryc = mysql_query($sqlc,$connect) or die("<center>query failed!<center>");
                    $listc = mysql_fetch_array($queryc);
                    print"                   
                    <tr>
                    <td>$lista[Gene_refGene]</td>
                    <td>$lista[AAChange_refGene]</td>";

                        
//pathogenicity Disease Disease_DB  Disease_DB_acc  Clinvar_Revstatus
// different disease
// ,            ,       ,           ,               ,
// ;            |       |           |               |
// same disease
//                      :           :

                    //find the different disease first
                    $Disease_fill        = "";
                    $Disease_db_fill     = "";
                    $Clin_revstatus_fill = "";
                    $pathogenicity_fill  = "";   
                    //separate by ',', different disease
                    if(strpos($listc[Disease],',') !== false){
                        $Disease_list_1        = explode(',',$listc[Disease]);
                        $Disease_db_list_1     = explode(',',$listc[Disease_DB]);
                        $Disease_db_acc_list_1 = explode(',',$listc[Disease_DB_acc]);
                        $Clin_rev_status_1     = explode(',',$listc[ClinVar_RevStat]);
                        $Pathogenicity_num_1   = explode(',',$listc[Pathogenicity_number]);
                        for($i = 0; $i < sizeof($Disease_list_1); $i++){
                            add_star($Disease_fill,$Disease_db_fill,$Clin_revstatus_fill,$pathogenicity_fill);
                            //separate by '|', different disease
                            if(strpos($Disease_list_1[$i],'|') !== false){
                                $Disease_list_2        = explode('|',$Disease_list_1[$i]);
                                $Disease_db_list_2     = explode('|',$Disease_db_list_1[$i]);
                                $Disease_db_acc_list_2 = explode('|',$Disease_db_acc_list_1[$i]);
                                $Clin_rev_status_2     = explode('|',$Clin_rev_status_1[$i]);
                                $Pathogenicity_num_2   = explode(';',$Pathogenicity_num_1[$i]);
                                for($j = 0; $j < sizeof($Disease_list_2); $j++){
                                    add_stroke($Disease_fill,$Disease_db_fill,$Clin_revstatus_fill,$pathogenicity_fill);
                                    //separate by ':', same disease
                                    if(strpos($Disease_db_list_2[$j],':') !== false){
                                        $Disease_db_list_sub     = explode(':',$Disease_db_list_2[$j]);
                                        $Disease_db_acc_list_sub = explode(':',$Disease_db_acc_list_2[$j]);
                                        add_content ($Disease_fill,$Disease_db_fill,$Clin_revstatus_fill,$pathogenicity_fill,$Disease_list_2[$j],$Disease_db_list_sub[0],$Disease_db_acc_list_sub[0],$Clin_rev_status_2[$j],$Pathogenicity_num_2[$j]);
                                        for($k = 1; $k < sizeof($Disease_db_list_sub); $k++){               
                                            add_content ($Disease_fill,$Disease_db_fill,$Clin_revstatus_fill,$pathogenicity_fill,"",$Disease_db_list_sub[$k],$Disease_db_acc_list_sub[$k],"","");
                                        }
                                    }
                                    else{
                                        add_content ($Disease_fill,$Disease_db_fill,$Clin_revstatus_fill,$pathogenicity_fill,$Disease_list_2[$j],$Disease_db_list_2[$j],$Disease_db_acc_list_2[$j],$Clin_rev_status_2[$j],$Pathogenicity_num_2[$j]);
                                    }
                                }
                            }
                            //after split by ',', there is no '|', but possibly has ':'
                            else if(strpos($Disease_db_list_1[$i],':') !== false){
                                $Disease_db_list_sub     = explode(':',$Disease_db_list_1[$i]);
                                $Disease_db_acc_list_sub = explode(':',$Disease_db_acc_list_1[$i]);
                                add_content ($Disease_fill,$Disease_db_fill,$Clin_revstatus_fill,$pathogenicity_fill,$Disease_list_1[$i],$Disease_db_list_sub[0],$Disease_db_acc_list_sub[0],$Clin_rev_status_1[$i],$Pathogenicity_num_1[$i]);
                                for($k = 1; $k < sizeof($Disease_db_list_sub); $k++){                                                                          add_content ($Disease_fill,$Disease_db_fill,$Clin_revstatus_fill,$pathogenicity_fill,"",$Disease_db_list_sub[$k],$Disease_db_acc_list_sub[$k],"","");
                                }
                            }
                            //the ',' split is an atom unit and has no further split elements
                            else{
                                add_content ($Disease_fill,$Disease_db_fill,$Clin_revstatus_fill,$pathogenicity_fill,$Disease_list_1[$i],$Disease_db_list_1[$i],$Disease_db_acc_list_1[$i],$Clin_rev_status_1[$i],$Pathogenicity_num_1[$i]);
                            }
                        }
                    }
                    //no ',' split, try '|'
                    else if(strpos($listc[Disease],'|') !== false){
                        $Disease_list_2        = explode('|',$listc[Disease]);
                        $Disease_db_list_2     = explode('|',$listc[Disease_DB]);
                        $Disease_db_acc_list_2 = explode('|',$listc[Disease_DB_acc]);
                        $Clin_rev_status_2     = explode('|',$listc[ClinVar_RevStat]);
                        $Pathogenicity_num_2   = explode(';',$listc[Pathogenicity_number]);
                        for($j = 0; $j < sizeof($Disease_list_2); $j++){
                            add_stroke($Disease_fill,$Disease_db_fill,$Clin_revstatus_fill,$pathogenicity_fill);
                            //separate by ':', same disease
                            if(strpos($Disease_db_list_2[$j],':') !== false){
                                $Disease_db_list_sub     = explode(':',$Disease_db_list_2[$j]);
                                $Disease_db_acc_list_sub = explode(':',$Disease_db_acc_list_2[$j]);
                                add_content ($Disease_fill,$Disease_db_fill,$Clin_revstatus_fill,$pathogenicity_fill,$Disease_list_2[$j],$Disease_db_list_sub[0],$Disease_db_acc_list_sub[0],$Clin_rev_status_2[$j],$Pathogenicity_num_2[$j]);
                                for($k = 1; $k < sizeof($Disease_db_list_sub); $k++){               
                                    add_content ($Disease_fill,$Disease_db_fill,$Clin_revstatus_fill,$pathogenicity_fill,"",$Disease_db_list_sub[$k],$Disease_db_acc_list_sub[$k],"","");
                                }
                            }
                            else{
                                add_content ($Disease_fill,$Disease_db_fill,$Clin_revstatus_fill,$pathogenicity_fill,$Disease_list_2[$j],$Disease_db_list_2[$j],$Disease_db_acc_list_2[$j],$Clin_rev_status_2[$j],$Pathogenicity_num_2[$j]);
                            }
                        }
                    }
                    //no ',' or '|', split by ':'
                    else if(strpos($listc[Disease_DB],':') !== false){
                        $Disease_db_list_sub     = explode(':',$listc[Disease_DB]);
                        $Disease_db_acc_list_sub = explode(':',$listc[Disease_DB_acc]);
                        add_content ($Disease_fill,$Disease_db_fill,$Clin_revstatus_fill,$pathogenicity_fill,$listc[Disease],$Disease_db_list_sub[0],$Disease_db_acc_list_sub[0],$listc[ClinVar_RevStat],$listc[Pathogenicity_number]);
                        
                        for($k = 1; $k < sizeof($Disease_db_list_sub); $k++){               
                            add_content ($Disease_fill,$Disease_db_fill,$Clin_revstatus_fill,$pathogenicity_fill,"",$Disease_db_list_sub[$k],$Disease_db_acc_list_sub[$k],"","");
                        }
                    }
                    //no split, the query result is already an atom unit
                    else{
                        add_content ($Disease_fill,$Disease_db_fill,$Clin_revstatus_fill,$pathogenicity_fill,$listc[Disease],$listc[Disease_DB],$listc[Disease_DB_acc],$listc[ClinVar_RevStat],$listc[Pathogenicity_number]);
                    }
                    
//                    <th>Disease</th>
//                    <th>Pathogenicity</th>
//                    <th>Revision Status</th>
//                    <th>Disease Database</th>
                    print "
                    <td>$Disease_fill</td>
                    <td>$Disease_db_fill</td>
                    <td>$Clin_revstatus_fill</td>
                    <td>$pathogenicity_fill</td>
                    <td>$lista[Func_refGene]</td>
                    <td>$lista[ExonicFunc_refGene]</td>";
                        
                    if($lista[ACMG_hit] === 0) {
                        print "<td id=acmg1>YES</td>";
                    }
                    else {
                        print "<td id=acmg0>NO</td>";
                    }
                    print"</tr>";
                    }while($lista = mysql_fetch_array($querya));
                    
                    print"</table>";
                    }
//                    echo "<certer><br>
//                    <form><input type=button class=button value=\"Back to previous\"     onclick=\"history.back();\"></form>";
//                    echo "<br></center>";   
                }
        print"
        <center><form method=post action=geneVarIntegration.php><center>
        ";
        
        start_view();
        if($_POST['gene_query']){
            gene_query();
//                        $query_format = $_POST['queryformat'];
//                        
//                        echo "you have selected: " .$query_format;
        }
        else if($_POST['allele_query']){
            allele_query();
        }
        else if($_POST['rsid_query']){
            rsid_query()
;       }
        else if($_POST['go_test']){
            query_view($_POST['gene_test'],"","","","","","","");
        }
//        if($_POST['suggestion']){
//            suggestion_box();        
//        }
//        $select_query = $_POST["select_query"];
//        if($select_query) {
//                    $queryformat = $_POST["queryformat"];  
//            $queryformat .= "| is what you selected";
//            echo $queryformat;
//
//                    if($queryformat == "GeneQuery"){
//                        gene_query();
//                    }    
//                    else if($queryformat == "AlleleQuery"){
//                        allele_query();
//                    }
//                    else{
//                        rsid_query();
//                    }
//
//                    }
//        else{
//            $errorMessage .= "<b>Please select the query format!</b>";
//        }
//        if(!isset($_POST['queryformat'])){
//            $errorMessage .= "<b>Please select the query format!</b>"
//        }
//        else{
//            $varQuery = $_POST['queryformat'];
//            if()
//        }
        $go_query = $_POST["go_query"];

        if($go_query) {
            $gene_name = $_POST["gene_name"];
            $chr_name = $_POST["chr_name"];
            $var_start= $_POST["var_start"];
            $var_end  = $_POST["var_end"];
            $gene_ref = $_POST["gene_ref"];
            $gene_alt = $_POST["gene_alt"];
            $rsid     = $_POST["rsid"]; 
            $animo_change = $_POST["animo_change"];
query_view($gene_name,$chr_name,$var_start,$var_end,$rsid,$gene_ref,$gene_alt,$animo_change);}       
            ?>
        </div>        
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="100px" height="100px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve" class="dont-render-dawg">
        <defs>
            <path id="github" filling="#7b0099" d="M8 0.198c-4.418 0-8 3.582-8 8 0 3.535 2.292 6.533 5.471 7.591 0.4 0.074 0.547-0.174 0.547-0.385 0-0.191-0.008-0.821-0.011-1.489-2.226 0.484-2.695-0.944-2.695-0.944-0.364-0.925-0.888-1.171-0.888-1.171-0.726-0.497 0.055-0.486 0.055-0.486 0.803 0.056 1.226 0.824 1.226 0.824 0.714 1.223 1.872 0.869 2.328 0.665 0.072-0.517 0.279-0.87 0.508-1.070-1.777-0.202-3.645-0.888-3.645-3.954 0-0.873 0.313-1.587 0.824-2.147-0.083-0.202-0.357-1.015 0.077-2.117 0 0 0.672-0.215 2.201 0.82 0.638-0.177 1.322-0.266 2.002-0.269 0.68 0.003 1.365 0.092 2.004 0.269 1.527-1.035 2.198-0.82 2.198-0.82 0.435 1.102 0.162 1.916 0.079 2.117 0.513 0.56 0.823 1.274 0.823 2.147 0 3.073-1.872 3.749-3.653 3.947 0.287 0.248 0.543 0.735 0.543 1.481 0 1.070-0.009 1.932-0.009 2.195 0 0.213 0.144 0.462 0.55 0.384 3.177-1.059 5.466-4.057 5.466-7.59 0-4.418-3.582-8-8-8z"></path>
            <g id="projects">
                <path d="M285.447,102.43l8.201-17.199c6.77-14.21,17.982-25.375,31.788-32.037h-60.099c5.047,9.139,4.487,19.28-4.116,29.312
                    C273.444,82.506,283.289,91.225,285.447,102.43z"/>
                <path d="M451.613,53.194h-56.761c21.415,17.028,19.008,40.074,1.818,47.24l-8.495,3.541c43.761,0,43.467-4.038,43.467,23.022
                    c5.823,12.082,5.389,25.918,0,37.699v144.151c0,6.149-4.986,11.135-11.135,11.135H56.559c-6.149,0-11.135-4.985-11.135-11.135
                    V152.559c-6.289-9.24-4.224-18.03-4.224-45.416c0-13.511,10.933-24.637,24.676-24.637c-7.501-7.493-9.705-19.101-4.084-29.312
                    h-36.34C11.399,53.194,0,64.592,0,78.646v269.218c0,14.054,11.399,25.453,25.453,25.453h168.696l-22.719,54.664h-10.421
                    c-9.053,0-16.398,7.345-16.398,16.4c0,9.053,7.345,16.398,16.398,16.398h155.046c9.055,0,16.4-7.345,16.4-16.398
                    c0-9.055-7.345-16.4-16.4-16.4h-10.419l-22.719-54.664h168.696c14.053,0,25.451-11.399,25.451-25.453V78.646
                    C477.065,64.592,465.666,53.194,451.613,53.194z M369.291,356.849c-6.585,0-11.927-5.343-11.927-11.927
                    c0-6.585,5.342-11.927,11.927-11.927c6.585,0,11.927,5.342,11.927,11.927C381.218,351.506,375.876,356.849,369.291,356.849z
                     M408.052,356.849c-6.585,0-11.927-5.343-11.927-11.927c0-6.585,5.342-11.927,11.927-11.927c6.585,0,11.927,5.342,11.927,11.927
                    C419.979,351.506,414.638,356.849,408.052,356.849z"/>
                <path d="M89.792,83.919c-2.438,4.597-4.472,9.434-6.025,14.489c-11.741,0-26.663-2.71-26.663,8.735
                    c0,44.197-4.503,40.369,26.647,40.369c1.57,5.055,3.603,9.901,6.041,14.496c-18.526,18.52-20.95,16.804-5.186,32.558
                    c9.861-10.669,19.116-12.564,48.109-24.645c-15.28-10.071-25.405-27.332-25.405-46.954c0-31.02,25.235-56.255,56.247-56.255
                    c34.956,0,62.181,31.921,55.145,67.374l51.324-21.4c0-16.593-4.457-14.279-26.665-14.279c-1.552-5.055-3.602-9.9-6.04-14.497
                    c8.293-8.3,20.794-16.966,12.703-25.057c-31.432-31.439-25.375-31.696-47.427-9.652c-4.597-2.438-9.427-4.48-14.504-6.025
                    c0-11.717,2.702-26.664-8.713-26.664c-44.197,0-40.361-4.519-40.361,26.664c-5.062,1.545-9.907,3.587-14.504,6.025
                    c-8.293-8.3-16.942-20.778-25.049-12.703C68.238,67.714,67.71,61.851,89.792,83.919z"/>
                <path d="M163.557,82.614c-22.253,0-40.345,18.099-40.345,40.353c0,18.433,12.485,33.853,29.397,38.661l46.092-19.21
                    C214.059,114.737,193.467,82.614,163.557,82.614z"/>
                <path d="M294.92,119.543l-188.294,78.479c-36.308,15.133-13.914,70.86,23.123,55.456l188.31-78.471
                    c49.074,17.192,51.092,19.342,88.1-4.123c20.328-12.897,15.668-45.159,3.198-40.004l-32.984,13.736
                    c-5.761,2.406-12.423-0.312-14.846-6.127c-16.71-40.066-19.24-32.62,29.025-52.73c12.098-5.039-6.957-31.354-30.671-25.88
                    l-16.368,3.735C314.379,70.268,307.81,92.452,294.92,119.543z"/>
            </g>         
        </defs>
    </body>
</html>
