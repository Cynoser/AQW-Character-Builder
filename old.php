<?php
/*
 * AQW Character Builder
 * Created by MentalBlank
 * File: index.php - v0.0.2
 */

function url_origin($s, $use_forwarded_host = false) {
    $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true : false;
    $sp = strtolower($s['SERVER_PROTOCOL']);
    $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
    $port = $s['SERVER_PORT'];
    $port = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
    $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
    $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
    return $protocol . '://' . $host;
}

function full_url($s, $use_forwarded_host = false) {
    return url_origin($s, $use_forwarded_host) . $s['REQUEST_URI'];
}

if (isset($_POST['username'])) {

    function get_source($username) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "www.aq.com/character.asp?id=" . str_replace(" ", "%20", $username));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    $getsource = get_source($_POST['username']);
    $preresult = explode('intColorHair', $getsource);
    $result = explode('" />', $preresult[1]);
    $result = "intColorHair" . $result[0];

    $original = array('intColorHair', 'intColorSkin', 'intColorEye', 'intColorTrim', 'intColorBase', 'intColorAccessory', 'ial', 'strGender', 'strHairFile', 'strHairName', 'strName', 'intLevel', 'strClassName', 'strClassFile', 'strClassLink', 'strArmorName', 'strWeaponFile', 'strWeaponLink', 'strWeaponType', 'strWeaponName', 'strCapeFile', 'strCapeLink', 'strCapeName', 'strHelmFile', 'strHelmLink', 'strHelmName', 'strPetFile', 'strPetLink', 'strPetName', 'bgindex');
    $replace = array('');

    $result = str_replace($original, $replace, $result);

    $splitted = explode("&", $result);

    $split_further = array('');
    for ($i = 0; $i < count($splitted); $i++) {
        $split_further[$i] = explode("=", $splitted[$i]);
    }
    header("Location: index.php?username=" . $split_further['10']['1'] . "&level=" . $split_further['11']['1'] . "&gender=" . $split_further['7']['1'] . "&class=" . $split_further['12']['1'] . "&plaColorHair=" . dechex($split_further['0']['1']) . "&plaColorSkin=" . dechex($split_further['1']['1']) . "&plaColorEyes=" . dechex($split_further['2']['1']) . "&cosColorTrim=" . dechex($split_further['3']['1']) . "&cosColorBase=" . dechex($split_further['4']['1']) . "&cosColorAccessory=" . dechex($split_further['5']['1']) . "&hairswf=" . $split_further['8']['1'] . "&hairlink=" . $split_further['9']['1'] . "&armfilename=" . $split_further['13']['1'] . "&armlinkage=" . $split_further['14']['1'] . "&wepfilename=" . $split_further['16']['1'] . "&weplinkage=" . $split_further['17']['1'] . "&helmfilename=" . $split_further['23']['1'] . "&helmlinkage=" . $split_further['24']['1'] . "&petfilename=" . $split_further['26']['1'] . "&petlinkage=" . $split_further['27']['1'] . "&capefilename=" . $split_further['20']['1'] . "&capelinkage=" . $split_further['21']['1'] . "&strArmorName=" . $split_further['15']['1'] . "&strWeaponType=" . $split_further['18']['1'] . "&strWeaponName=" . $split_further['19']['1'] . "&strPetName=" . $split_further['28']['1'] . "&strCapeName=" . $split_further['22']['1'] . "&strHelmName=" . $split_further['25']['1'] . "&bgindex=" . $split_further['29']['1']);
} else {
    //CHARACTER INFO INFORMATION
    if (isset($_GET["username"])) {
        $username = $_GET["username"];
    } else {
        $username = "artix";
    };
    $objRS1['gender'] = $_GET["gender"];
    if (isset($_GET["Level"])) {
        $level = $_GET["level"];
    } else {
        $level = "60";
    };
    //COLOR INFORMATION
    if (isset($_GET['plaColorHair'])) {
        $objRS1['plaColorHair'] = $_GET['plaColorHair'];
    } else {
        $objRS1['plaColorHair'] = "382216";
    }
    if (isset($_GET['plaColorSkin'])) {
        $objRS1['plaColorSkin'] = $_GET['plaColorSkin'];
    } else {
        $objRS1['plaColorSkin'] = "E6BC93";
    }
    if (isset($_GET['plaColorEyes'])) {
        $objRS1['plaColorEyes'] = $_GET['plaColorEyes'];
    } else {
        $objRS1['plaColorEyes'] = "5C2E2F";
    }
    if (isset($_GET['cosColorTrim'])) {
        $objRS1['cosColorTrim'] = $_GET['cosColorTrim'];
    } else {
        $objRS1['cosColorTrim'] = "52617C";
    }
    if (isset($_GET['cosColorBase'])) {
        $objRS1['cosColorBase'] = $_GET['cosColorBase'];
    } else {
        $objRS1['cosColorBase'] = "8291AC";
    }
    if (isset($_GET['cosColorAccessory'])) {
        $objRS1['cosColorAccessory'] = $_GET['cosColorAccessory'];
    } else {
        $objRS1['cosColorAccessory'] = "990000";
    }

    //HAIR INFORMATION
    if ($_GET['hairswf'] == "" || $_GET['hairlink'] == "") {
        $objRS1['hairFile'] = "hair/M/Normal.swf";
        $objRS1['hairName'] = "Normal";
    } else {
        $objRS1['hairFile'] = $_GET["hairswf"];
        $objRS1['hairName'] = $_GET["hairlink"];
    }

    //CLASS INFORMATION
    $ca['sName'] = $_GET["class"];
    if (!isset($_GET['armfilename']) || !isset($_GET['armlinkage'])) {
        $armco = "paladin_skin.swf";
        $armcol = "Paladin";
        $armname = "Paladin";
    } else {
        $armco = $_GET['armfilename'];
        $armcol = $_GET['armlinkage'];
        $armname = $_GET['strArmorName'];
    }

    //WEAPON INFORMATION
    if (!isset($_GET['wepfilename'])) {
        $weaponfile = "items/axes/axe05.swf";
        $weaponlink = "";
        $weaponname = "Blinding Light of Destiny III";
        $weapontype = "Sword";
    } else {
        $weaponfile = $_GET['wepfilename'];
        $weaponlink = $_GET['weplinkage'];
        $weaponname = $_GET['strWeaponName'];
        $weapontype = $_GET['strWeaponType'];
    }

    //CAPE INFORMATION
    if (!isset($_GET['petfilename'])) {
        $bafile = "items/capes/redcape.swf";
        $balink = "RedCape";
        $baname = "Red Cape";
    } else {
        $bafile = $_GET['capefilename'];
        $balink = $_GET['capelinkage'];
        $baname = $_GET['strCapeName'];
    }

    //HELM INFORMATION:
    if (!isset($_GET['helmfilename'])) {
        $helmhair = "none";
        $helmhairl = "none";
        $helmname = "None";
    } else {
        $helmhair = $_GET['helmfilename'];
        $helmhairl = $_GET['helmlinkage'];
        $helmname = $_GET['strHelmName'];
    }
    //PET INFORMATION
    if (!isset($_GET['petfilename'])) {
        $cpfile = "items/pets/ArmoredDaimyoBattle.swf";
        $cplink = "ArmoredDaimyoBattle";
        $cpname = "Armored Daimyo";
    } else {
        $cpfile = $_GET['petfilename'];
        $cplink = $_GET['petlinkage'];
        $cpname = $_GET['strPetName'];
    }
    //Old Char SWF: http://game.aqworlds.com/flash/character.swf
    //New Char SWF: http://cdn.aqworlds.com/flash/chardetail/character3.swf
    ?>
    <html>
        <head>
            <link href="style.css" rel="stylesheet" type="text/css">
            <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
        </head>
        <body onload="makecode()">
            <script src="http://jscolor.com/jscolor/jscolor.js"></script>
            <script type="text/javascript" src="http://davidwalsh.name/dw-content/ZeroClipboard.js"></script>
            <script>makecode();</script>
            <table>
                <tr>
                    <td>
                        <table class="inside">
                            <tr>
                                <td><b>Username:</b></td>
                                <td><input onChange="javascript:makecode()" type="text" name="strUsername" value="<?php echo $username; ?>"></td>
                            </tr>
                            <tr>
                                <td><b>Level:</b></td>
                                <td><input onChange="javascript:makecode()" type="text" name="intLevel" value="<?php echo $level; ?>"></td>
                            </tr>
                            <tr>
                                <td><b>Class:</b></td>
                                <td><input onChange="javascript:makecode()" type="text" name="charclass" value="<?php echo $ca['sName']; ?>"></td>
                            </tr>
                            <tr>
                                <td><b>Gender:</b></td>
                                <td>
                                    <select onChange="javascript:makecode()" type="text" name="strGender">
                                        <option value='M' <?php if ($objRS1['gender'] == 'M') {
        echo "selected='true'";
    } ?>>Male</option>";
                                        <option value='F' <?php if ($objRS1['gender'] == 'F') {
        echo "selected='true'";
    } ?>>Female</option>";
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Hair:</b></td>
                                <td><input onChange="javascript:makecode()" type="text" name="hairfile" value="<?php echo $objRS1['hairFile']; ?>"></td>
                                <td><input onChange="javascript:makecode()" type="text" name="hairname" value="<?php echo $objRS1['hairName']; ?>"></td>
                            </tr>
                            <tr>
                                <td><b>Skin Color:</b></td>
                                <td><input onChange="javascript:makecode()" class="color" name="skincol" value="<?php echo $objRS1['plaColorSkin']; ?>"></td>
                            </tr>
                            <tr>
                                <td><b>Hair Color:</b></td>
                                <td><input onChange="javascript:makecode()" class="color" name="haircol" value="<?php echo $objRS1['plaColorHair']; ?>"></td>
                            </tr>
                            <tr>
                                <td><b>Eye Color:</b></td>
                                <td><input onChange="javascript:makecode()" class="color" name="eyecol" value="<?php echo $objRS1['plaColorEyes']; ?>"></td>
                            </tr>
                            <tr>
                                <td><b>Armor Trim Color:</b></td>
                                <td><input onChange="javascript:makecode()" class="color" name="trimcol" value="<?php echo $objRS1['cosColorTrim']; ?>"></td>
                            </tr>
                            <tr>
                                <td><b>Armor Base Color:</b></td>
                                <td><input onChange="javascript:makecode()" class="color" name="basecol" value="<?php echo $objRS1['cosColorBase']; ?>"></td>
                            </tr>
                            <tr>
                                <td><b>Accessory Color:</b></td>
                                <td><input onChange="javascript:makecode()" class="color" name="acccol" value="<?php echo $objRS1['cosColorAccessory']; ?>"></td>
                            </tr>
                            <tr>
                                <td><b><img src="images/armor.png" width="15px" /> Armor:</b></td>
                                <td><input onChange="javascript:makecode()" type="text" name="armorfile" value="<?php echo $armco; ?>"></td>
                                <td><input onChange="javascript:makecode()" type="text" name="armorlink" value="<?php echo $armcol; ?>"></td>
                                <td><input onChange="javascript:makecode()" type="text" name="armorname" value="<?php echo $armname; ?>"></td>
                            </tr>
                            <tr>
                                <td><b><img src="images/weapon.png" width="15px" /> Weapon:</b></td>
                                <td><input onChange="javascript:makecode()" type="text" name="wepfile" value="<?php echo $weaponfile; ?>"></td>
                                <td><input onChange="javascript:makecode()" type="text" name="weplink" value="<?php echo $weaponlink; ?>"></td>
                                <td><input onChange="javascript:makecode()" type="text" name="wepname" value="<?php echo $weaponname; ?>"></td>
                            </tr>
                            <tr>
                                <td><b><img src="images/cape.png" width="15px" /> Cape:</b></td>
                                <td><input onChange="javascript:makecode()" type="text" name="bafile" value="<?php echo $bafile; ?>"></td>
                                <td><input onChange="javascript:makecode()" type="text" name="balink" value="<?php echo $balink; ?>"></td>
                                <td><input onChange="javascript:makecode()" type="text" name="baname" value="<?php echo $baname; ?>"></td>
                            </tr>
                            <tr>
                                <td><b><img src="images/helm.png" width="15px" /> Helm:</b></td>
                                <td><input onChange="javascript:makecode()" type="text" name="helmfile" value="<?php echo $helmhair; ?>"></td>
                                <td><input onChange="javascript:makecode()" type="text" name="helmlink" value="<?php echo $helmhairl; ?>"></td>
                                <td><input onChange="javascript:makecode()" type="text" name="helmname" value="<?php echo $helmname; ?>"></td>
                            </tr>
                            <tr>
                                <td><b><img src="images/pet.png" width="15px" /> Pet:</b></td>
                                <td><input onChange="javascript:makecode()" type="text" name="hairfile" value="<?php echo $cpfile; ?>"></td>
                                <td><input onChange="javascript:makecode()" type="text" name="hairlink" value="<?php echo $cplink; ?>"></td>
                                <td><input onChange="javascript:makecode()" type="text" name="hairname" value="<?php echo $cpname; ?>"></td>
                            </tr>
                            <tr>
                            <form action="index.php" method="post">
                                <td><b>Grab From Username:</b></td>
                                <td><input type="text" name="username" value="Artix"></td>
                                <td><input type="submit" name="submit" value="Grab From Username"></td>
                            </form>
                </tr>
                <tr>
                    <td><b>Background:</b></td>
                    <td>
                        <select onChange="javascript:makecode()" type="text" name="background">
                            <option value='6' <?php if ($_GET['bgindex'] == "6") {
        echo"selected='true'";
    } ?>>Shadowfall</option>";
                            <option value='0' <?php if ($_GET['bgindex'] == "0") {
        echo"selected='true'";
    } ?>>Battleon</option>";
                            <option value='1' <?php if ($_GET['bgindex'] == "1") {
        echo"selected='true'";
    } ?>>DoomWood Forest</option>";
                            <option value='2' <?php if ($_GET['bgindex'] == "2") {
        echo"selected='true'";
    } ?>>Ledgermayne</option>";
                            <option value='3' <?php if ($_GET['bgindex'] == "3") {
        echo"selected='true'";
    } ?>>Lightguard Keep</option>";
                            <option value='4' <?php if ($_GET['bgindex'] == "4") {
        echo"selected='true'";
    } ?>>Northland Lights</option>";
                            <option value='5' <?php if ($_GET['bgindex'] == "5") {
        echo"selected='true'";
    } ?>>Djinn</option>";
                            <option value='7' <?php if ($_GET['bgindex'] == "7") {
        echo"selected='true'";
    } ?>>Skyguard</option>";
                            <option value='8' <?php if ($_GET['bgindex'] == "8") {
        echo"selected='true'";
    } ?>>The Void</option>";
                            <option value='9' <?php if ($_GET['bgindex'] == "9") {
        echo"selected='true'";
    } ?>>Yulgars' Inn</option>";
                            <option value='A' <?php if ($_GET['bgindex'] == "A") {
        echo"selected='true'";
    } ?>>Mogloween</option>";
                            <option value='B' <?php if ($_GET['bgindex'] == "B") {
        echo"selected='true'";
    } ?>>Frostvale</option>";
                            <option value='C' <?php if ($_GET['bgindex'] == "C") {
        echo"selected='true'";
    } ?>>Love</option>";
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><b>Enable Custom Items:</b></td>
                    <td>
                        <select onChange="javascript:makecode()" type="text" name="aqwURLS" disabled="true">
                            <option value='1'>AQW Items Only</option>";
                            <option value='2'>Custom Items</option>";
                        </select>
                    </td>
                </tr>
            </table>
        </td>
    <td class="outside">
    <center><h1>MentalBlank's AQW Character Builder</h2>
            <a href="http://forum.nothingillegal.com/">NothingIllegal Forums</a> <a href="http://alphafable.info">MentalBlank's Junk</a><br /><br />
            <textarea rows="2" cols="60"><?php echo(full_url($_SERVER)); ?></textarea>
    </center>
    <br />
    <characterpreview />
    <script>
        function d2h(d) {
            return d.toString(16);
        }
        function h2d(h) {
            return parseInt(h, 16);
        }
        function makecode()
        {
            if (document.getElementsByTagName('select')[2].value == "2") {
                var swfurl = "character.swf"
            } else {
                var swfurl = "http://cdn.aqworlds.com/flash/chardetail/character3.swf"
            }
            var name = document.getElementsByTagName('input')[0].value
            var lvl = document.getElementsByTagName('input')[1].value
            var charclass = document.getElementsByTagName('input')[2].value
            var gender = document.getElementsByTagName('select')[0].value
            var hair = document.getElementsByTagName('input')[3].value
            var hairlink = document.getElementsByTagName('input')[4].value
            var skincolor = h2d(document.getElementsByTagName('input')[5].value)
            var haircolor = h2d(document.getElementsByTagName('input')[6].value)
            var eyecolor = h2d(document.getElementsByTagName('input')[7].value)
            var trim = h2d(document.getElementsByTagName('input')[8].value)
            var base = h2d(document.getElementsByTagName('input')[9].value)
            var accessory = h2d(document.getElementsByTagName('input')[10].value)
            var armor = document.getElementsByTagName('input')[11].value
            var armorlink = document.getElementsByTagName('input')[12].value
            var armname = document.getElementsByTagName('input')[13].value
            var weapon = document.getElementsByTagName('input')[14].value
            var weaponlink = document.getElementsByTagName('input')[15].value
            var weapontype = "Sword"//document.getElementsByTagName('input')[16].value
            var weaponname = document.getElementsByTagName('input')[16].value
            var cape = document.getElementsByTagName('input')[17].value
            var capelink = document.getElementsByTagName('input')[18].value
            var baname = document.getElementsByTagName('input')[19].value
            var helm = document.getElementsByTagName('input')[20].value
            var helmlink = document.getElementsByTagName('input')[21].value
            var helmname = document.getElementsByTagName('input')[22].value
            var pet = document.getElementsByTagName('input')[23].value
            var petlink = document.getElementsByTagName('input')[24].value
            var cpname = document.getElementsByTagName('input')[25].value
            var background = document.getElementsByTagName('select')[1].value
            document.getElementsByTagName('textarea')[0].value = "http://alphahub.org/charbuild/index.php?username=" + name + "&level=" + lvl + "&gender=" + gender + "&class=" + charclass + "&plaColorHair=" + d2h(haircolor) + "&plaColorSkin=" + d2h(skincolor) + "&plaColorEyes=" + d2h(eyecolor) + "&cosColorTrim=" + d2h(trim) + "&cosColorBase=" + d2h(base) + "&cosColorAccessory=" + d2h(accessory) + "&hairswf=" + hair + "&hairlink=" + hairlink + "&armfilename=" + armor + "&armlinkage=" + armorlink + "&wepfilename=" + weapon + "&weplinkage=" + weaponlink + "&helmfilename=" + helm + "&helmlinkage=" + helmlink + "&petfilename=" + pet + "&petlinkage=" + petlink + "&capefilename=" + cape + "&capelinkage=" + capelink + "&strArmorName=" + armname + "&strWeaponType=" + weapontype + "&strWeaponName=" + weaponname + "&strPetName=" + cpname + "&strCapeName=" + baname + "&strHelmName=" + helmname + "&bgindex=" + background;
            var code = '<embed src="' + swfurl + '" width="550" height="350" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" flashvars="intColorHair=' + haircolor + '&intColorSkin=' + skincolor + '&intColorEye=' + eyecolor + '&intColorTrim=' + trim + '&intColorBase=' + base + '&intColorAccessory=' + accessory + '&strGender=' + gender + '&strHairFile=' + hair + '&strHairName=' + hairlink + '&strName=' + name + '&intLevel=' + lvl + '&strClassName=' + charclass + '&strClassFile=' + armor + '&strClassLink=' + armorlink + '&strWeaponFile=' + weapon + '&strWeaponLink=' + weaponlink + '&strCapeFile=' + cape + '&strCapeLink=' + capelink + '&strHelmFile=' + helm + '&strHelmLink=' + helmlink + '&strPetFile=' + pet + '&strPetLink=' + petlink + '&strArmorName=' + armname + '&strWeaponType=' + weapontype + '&strWeaponName=' + weaponname + '&strPetName=' + cpname + '&strCapeName=' + baname + '&strHelmName=' + helmname + '&bgindex=' + background + '&ia1=1"></embed></object>';
            void(document.getElementsByTagName('characterpreview')[0].innerHTML = code);
        }
        ;
    </script>
    </td>
    </tr>
    </table>
    </body>
    </html>
    <?php
}
?>