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

    $original = array('intColorHair', 'intColorSkin', 'intColorEye', 'intColorTrim', 'intColorBase', 'intColorAccessory', 'ial', 'strGender', 'strHairFile', 'strHairName', 'strName', 'intLevel', 'strClassName', 'strClassFile', 'strClassLink', 'strArmorName', 'strWeaponFile', 'strWeaponLink', 'strWeaponType', 'strWeaponName', 'strCapeFile', 'strCapeLink', 'strCapeName', 'strHelmFile', 'strHelmLink', 'strHelmName', 'strPetFile', 'strPetLink', 'strPetName', 'bgindex', 'faction');
    $replace = array('');

    $result = str_replace($original, $replace, $result);

    $splitted = explode("&", $result);

    $split_further = array('');
    for ($i = 0; $i < count($splitted); $i++) {
        $split_further[$i] = explode("=", $splitted[$i]);
    }
    $FACTION2 = explode("\"", $split_further['30']['1']);
    header("Location: index.php?grabbed=true&username=" . $split_further['10']['1'] . "&level=" . $split_further['11']['1'] . "&gender=" . $split_further['7']['1'] . "&class=" . $split_further['12']['1'] . "&plaColorHair=" . dechex($split_further['0']['1']) . "&plaColorSkin=" . dechex($split_further['1']['1']) . "&plaColorEyes=" . dechex($split_further['2']['1']) . "&cosColorTrim=" . dechex($split_further['3']['1']) . "&cosColorBase=" . dechex($split_further['4']['1']) . "&cosColorAccessory=" . dechex($split_further['5']['1']) . "&hairswf=" . $split_further['8']['1'] . "&hairlink=" . $split_further['9']['1'] . "&armfilename=" . $split_further['13']['1'] . "&armlinkage=" . $split_further['14']['1'] . "&wepfilename=" . $split_further['16']['1'] . "&weplinkage=" . $split_further['17']['1'] . "&helmfilename=" . $split_further['23']['1'] . "&helmlinkage=" . $split_further['24']['1'] . "&petfilename=" . $split_further['26']['1'] . "&petlinkage=" . $split_further['27']['1'] . "&capefilename=" . $split_further['20']['1'] . "&capelinkage=" . $split_further['21']['1'] . "&strArmorName=" . $split_further['15']['1'] . "&strWeaponType=" . $split_further['18']['1'] . "&strWeaponName=" . $split_further['19']['1'] . "&strPetName=" . $split_further['28']['1'] . "&strCapeName=" . $split_further['22']['1'] . "&strHelmName=" . $split_further['25']['1'] . "&bgindex=" . $split_further['29']['1'] . "&faction=" . $FACTION2['0']);
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
    if (isset($_GET["faction"])) {
        $faction = $_GET["faction"];
    } else {
        $faction = "Good";
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
    if (!isset($_GET['armfilename']) || !isset($_GET['armlinkage'])) {
        $armco = "paladin_skin.swf";
        $armcol = "Paladin";
        $armname = "Paladin";
        $ca['sName'] = "Paladin";
    } else {
        $armco = $_GET['armfilename'];
        $armcol = $_GET['armlinkage'];
        $armname = $_GET['strArmorName'];
        $ca['sName'] = $_GET["class"];
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

    if (isset($_GET["grabbed"])) {
        $grabbed = "grabbed";
    }
    ?>
    <html>
        <head>
            <link href="style.css" rel="stylesheet" type="text/css">
            <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
        </head>
        <body onload="makecode()">
            <script src="jscolor.js"></script>
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
                                        <option value='M' <?php
                                        if ($objRS1['gender'] == 'M') {
                                            echo "selected='true'";
                                        }
                                        ?>>Male</option>";
                                        <option value='F' <?php
                                        if ($objRS1['gender'] == 'F') {
                                            echo "selected='true'";
                                        }
                                        ?>>Female</option>";
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
                                <td><input onChange="javascript:makecode()" class="jscolor jscolor-active" name="skincol" value="<?php echo $objRS1['plaColorSkin']; ?>"></td>
                            </tr>
                            <tr>
                                <td><b>Hair Color:</b></td>
                                <td><input onChange="javascript:makecode()" class="jscolor jscolor-active" name="haircol" value="<?php echo $objRS1['plaColorHair']; ?>"></td>
                            </tr>
                            <tr>
                                <td><b>Eye Color:</b></td>
                                <td><input onChange="javascript:makecode()" class="jscolor jscolor-active" name="eyecol" value="<?php echo $objRS1['plaColorEyes']; ?>"></td>
                            </tr>
                            <tr>
                                <td><b>Armor Trim Color:</b></td>
                                <td><input onChange="javascript:makecode()" class="jscolor jscolor-active" name="trimcol" value="<?php echo $objRS1['cosColorTrim']; ?>"></td>
                            </tr>
                            <tr>
                                <td><b>Armor Base Color:</b></td>
                                <td><input onChange="javascript:makecode()" class="jscolor jscolor-active" name="basecol" value="<?php echo $objRS1['cosColorBase']; ?>"></td>
                            </tr>
                            <tr>
                                <td><b>Accessory Color:</b></td>
                                <td><input onChange="javascript:makecode()" class="jscolor jscolor-active" name="acccol" value="<?php echo $objRS1['cosColorAccessory']; ?>"></td>
                            </tr>
                            <tr>
                                <td><b>SWF Input:</b></td>
                                <td>
                                    <button onclick="useSWF()">Use SWF</button>
                                    <button onclick="useDrops()">Use Drops</button>
                                </td>
                            </tr>
                            <tr>
                                <td><b><img src="images/armor.png" width="15px" /> Armor:</b></td>
                                <td style="display:none;"><input onChange="javascript:ChangeItem('armor')" type="text" name="armorfile" value="<?php echo $armco; ?>"></td>
                                <td style="display:none;"><input onChange="javascript:ChangeItem('armor')" type="text" name="armorlink" value="<?php echo $armcol; ?>"></td>
                                <td style="display:none;"><input onChange="javascript:ChangeItem('armor')" type="text" name="armorname" value="<?php echo $armname; ?>"></td>
                                <td><select id="armor" onChange="javascript:ChangeItem('armor')" NAME="ArmorSelect">
                                        <Option value="paladin_skin.swf~Paladin">Paladin Class</option>
                                        <Option value="Disco1.swf~Disco1">8 Track Flashback Armor</option>
                                        <Option value="Priest2_skin.swf~Priest2">Acolyte</option>
                                        <Option value="ClawSuitAdvanced.swf~ClawSuitAdvanced">Advanced ClawSuit</option>
                                        <Option value="Agility.swf~Agility">Agility Racer</option>
                                        <Option value="Alac_skin.swf~Alac">Alac's Skin [F]</option>
                                        <Option value="Lycan2_skin.swf~Lycan2">Alpha Lycan</option>
                                        <Option value="pirate2_skin.swf~Pirate2">Alpha Pirate</option>
                                        <Option value="FootballSaint_skin.swf~FootballSaint">Angel Avengers Team</option>
                                        <Option value="Anubis.swf~Anubis">Anubis Armor</option>
                                        <Option value="arachnomancer_skin.swf~arachnomancer">Arachnomancer</option>
                                        <Option value="MiltonPoolMage_skin.swf~MiltonPoolMage">Arcane Battle Armor</option>
                                        <Option value="MiltonPoolMageCC_skin.swf~MiltonPoolMageCC">Arcane of Mitonius</option>
                                        <Option value="TrydethsArcanist.swf~TrydethsArcanist">Arcanist Robes</option>
                                        <Option value="UltraDS.swf~UltraDS">Arctic Dragonslayer</option>
                                        <Option value="PrezSuit_skin.swf~PrezSuit">Armor Shaped Giftbox</option>
                                        <Option value="Hashashin1_skin.swf~Hashashin1">Armored Hashashin Armor</option>
                                        <Option value="artixchainsaw_skin.swf~Artix1">Artix Chainsaw Skin</option>
                                        <Option value="AsgardianPlate.swf~AsgardianPlate">Asgardian Plate</option>
                                        <Option value="asgir_skin.swf~Asgir">Asgir Armor</option>
                                        <Option value="SandArmor2.swf~SandArmor2">Assassin of the Sands</option>
                                        <Option value="rogue4_skin.swf~Rogue4">Assassin</option>
                                        <Option value="Astral.swf~Astral">Astral Entity</option>
                                        <Option value="Ballyhoo_skin.swf~Ballyhoo">Ballyhoo [F]</option>
                                        <Option value="banana_skin.swf~Bana">Banana Suit</option>
                                        <Option value="Banisher.swf~Banisher">Banisher Armor</option>
                                        <Option value="druid1_skin.swf~Druid1">Barbaric Tribesman</option>
                                        <Option value="barber_skin.swf~Barber">Barber Class</option>
                                        <Option value="Bard_Skin.swf~Bard1">Bard</option>
                                        <Option value="baron_skin.swf~Baron">Baron</option>
                                        <Option value="swim1_skin.swf~Swim1">Battle Swimwear</option>
                                        <Option value="BTAMaster.swf~BTAMaster">Battle Tested Axe Master</option>
                                        <Option value="Xbox2_skin.swf~Xbox2">Battle Zeke</option>
                                        <Option value="bbq_skin.swf~BBQ">BBQ Appron 09</option>
                                        <Option value="beast1_skin.swf~Beast1">Beast Warrior Class</option>
                                        <Option value="BeleensDruid.swf~BeleensDruid">Beleen's Druid Armor [F]</option>
                                        <Option value="warrior10_skin.swf~War10">Berserker Champion</option>
                                        <Option value="warrior2_skin.swf~Warrior2">Berserker</option>
                                        <Option value="bunnyberzerk1_skin.swf~Bunnyberzerk1">Berzerker Bunny</option>
                                        <Option value="warrior2a_skin.swf~Warrior2a">Beta Berserker</option>
                                        <Option value="Heartsuit1_skin.swf~Heartsuit1">Big Daddy Helper</option>
                                        <Option value="knight2_skin.swf~knight2">Black Knight</option>
                                        <Option value="BlackMage_skin.swf~BlackMage">Black Mage Robes</option>
                                        <Option value="ninjablack_skin.swf~NinjaBlack">Black Ninja</option>
                                        <Option value="BlackRogue_skin.swf~BlackRogue">Black Rogue Armor</option>
                                        <Option value="BladeMaster.swf~BladeMaster">Blade Master Beta [M]</option>
                                        <Option value="BladeMaster2.swf~BladeMaster2">Blade Master</option>
                                        <Option value="football2_skin.swf~Football2">Blood Hawk Team</option>
                                        <Option value="ninja3_skin.swf~Ninja3">Blood Ninja</option>
                                        <Option value="MiltonPool3_skin.swf~MiltonPool3">Blood of Miltonius</option>
                                        <Option value="KarateBlue_skin.swf~KarateBlue">Blue Karategi</option>
                                        <Option value="cowboy1_skin.swf~Cowboy1">Bounty Hunter</option>
                                        <Option value="bride_skin.swf~Bride">Bride</option>
                                        <Option value="CADSidekick.swf~CADSidekick">CAD Sidekick</option>
                                        <Option value="CardCaster.swf~CardCaster">CardClasher Class</option>
                                        <Option value="CarpetRacer.swf~CarpetRacer">Carpet Racer</option>
                                        <Option value="CelSand.swf~CelSand">Celestial Sandknight</option>
                                        <Option value="CelticMage.swf~CelticMage">Celtic Caster</option>
                                        <Option value="CelticAssassin.swf~CelticAssassin">Celtic Cutthroat</option>
                                        <Option value="CelticSWarrior.swf~CelticSWarrior">Celtic Destroyer</option>
                                        <Option value="warrior5_skin.swf~Warrior5">Celtic Warrior</option>
                                        <Option value="Greek1_skin.swf~Greek1">Centurion Armor</option>
                                        <Option value="Frozenarmor1_skin.swf~Frozenarmor1">Champion of the North</option>
                                        <Option value="Santa5.swf~Santa5">Chaos Claws Suit</option>
                                        <Option value="watcher_skin.swf~watcher">Chaos Sp-eye</option>
                                        <Option value="chaossymbiote.swf~chaossymbiote">Chaos Symbiote</option>
                                        <Option value="ChaosWarrrior.swf~ChaosWarrrior">Chaos Warrrior</option>
                                        <Option value="ChickenManSuit.swf~ChickenManSuit">Chickenman Suit</option>
                                        <Option value="Chrono.swf~Chrono">Chronomancer Armor</option>
                                        <Option value="Santa1_skin.swf~Santa1">Claw Suit</option>
                                        <Option value="CloverStalker.swf~CloverStalker">Clover Stalker</option>
                                        <Option value="CCZhoom.swf~CCZhoom">Color Custom Zhoom</option>
                                        <Option value="santa2_skin.swf~Santa2">Colorful Claws Suit</option>
                                        <Option value="Armor2A_skin.swf~Armor2A">Conqueror of Shadow</option>
                                        <Option value="twinsMiltonPool4_skin.swf~twinsMiltonPool4">Cool Girl</option>
                                        <Option value="CorpseKnight_skin.swf~CorpseKnight">Corpse Knight</option>
                                        <Option value="Creeper1Miltonius_skin.swf~Creeper1Miltonius">Creeper Skin</option>
                                        <Option value="paladin2_skin.swf~Paladin2">Crimson Paladin</option>
                                        <Option value="MiltonPool6_skin.swf~MiltonPool6">Crimson Plate of Miltonius</option>
                                        <Option value="CursedCap_skin.swf~CursedCap">Cursed Pirate Captain</option>
                                        <Option value="CyberHunter.swf~CyberHunter">Cyber Hunter</option>
                                        <Option value="cysero_skin.swf~Cysero">Cysero's Armor</option>
                                        <Option value="Tunicedo.swf~Tunicedo">Cysero's Wedding Garb</option>
                                        <Option value="DagesDeathKnight.swf~DagesDeathKnight">Dage the Evil's Death Knight</option>
                                        <Option value="ParagonPlate.swf~ParagonPlate">Dage's Paragon Plate</option>
                                        <Option value="priest3_skin.swf~Priest3">Dark Acolyte</option>
                                        <Option value="DarkArtsScolar.swf~DarkArtsScolar">Dark Arts Scholar</option>
                                        <Option value="DarkCaster.swf~DarkCaster">Dark Caster Beta [M]</option>
                                        <Option value="DarkCaster.swf~DarkCaster">Dark Caster</option>
                                        <Option value="Darkcaster2.swf~DarkCaster2">Dark Caster</option>
                                        <Option value="Darkcrusader_skin.swf~Darkcrusader">Dark Crusader</option>
                                        <Option value="DrudicNecroMage.swf~DrudicNecroMage">Dark Druid Armor</option>
                                        <Option value="ninjanorm1_skin.swf~ninjanorm1">Dark Ninja Garb</option>
                                        <Option value="Cenobite1_skin.swf~Cenobite1">Dark Zenobyte</option>
                                        <Option value="MiltonPoolDdog1_skin.swf~MiltonPoolDdog1">Ddog's Sea Serpent Armor</option>
                                        <Option value="DeathKnightLesser.swf~DeathKnightLesser">Dead Knight</option>
                                        <Option value="DeathknightSupreme.swf~DeathknightSupreme">DeathKnight Supreme</option>
                                        <Option value="Defender.swf~Defender">Defender Class</option>
                                        <Option value="demon1_skin.swf~Demon1">Demon Miltonius</option>
                                        <Option value="Ninjudo1.swf~Ninjudo1">Demonic Nemesis</option>
                                        <Option value="Des.swf~Des">Des Armor</option>
                                        <Option value="CNYDragon.swf~CNYDragon">Descendant of the Dragon</option>
                                        <Option value="suit1_skin.swf~Suit1">Detective Suit</option>
                                        <Option value="DigitalDK_skin.swf~DigitalDK">Digital DOOMKnight</option>
                                        <Option value="MiltonPoolFire_skin.swf~MiltonPoolFire">Dimensional Champion Of Miltonius</option>
                                        <Option value="DogDude.swf~DogDude">Dog Dude</option>
                                        <Option value="Dorothy.swf~Dorothy">Dorian and Dorothy</option>
                                        <Option value="dragonlord_skin.swf~Dragonlord">Dragonlord Armor</option>
                                        <Option value="dragonslayer_skin.swf~Dragonslayer">Dragonslayer</option>
                                        <Option value="Drak.swf~Drak">Drakonnan</option>
                                        <Option value="Drakonus_skin.swf~Drakonus">Drakonus Armour</option>
                                        <Option value="Freddy1_skin.swf~Freddy1">Dream Slayer</option>
                                        <Option value="Drow1_skin.swf~Drow1">Drow Assassin</option>
                                        <Option value="Dwarf3_skin.swf~Dwarf3_skin">Dwarf Warrior Armor</option>
                                        <Option value="EdvardBeulah_skin.swf~EdvardBeulah">Edvard/Beulah Outfit</option>
                                        <Option value="Efreet1_skin.swf~Efreet1">Efreet</option>
                                        <Option value="Komono2_skin.swf~Komono2">Elegant Kimono</option>
                                        <Option value="EmoMiltonPool1_skin.swf~Emo1">Emo Rocker</option>
                                        <Option value="mech2b_skin.swf~Mech2b">Enforcer Class</option>
                                        <Option value="Escherion_skin.swf~Escherion">Escherion's Robe</option>
                                        <Option value="Ethan.swf~Ethan">Ethan's Kingly Attire</option>
                                        <Option value="NewBunnyberzerk.swf~NewBunnyberzerk">Evolved Bunny Berserker</option>
                                        <Option value="ClawSuitAdvanced.swf~ClawSuitAdvanced">Evolved ClawSuit</option>
                                        <Option value="dragonlord2_skin.swf~Dragonlord2">Evolved DragonLord</option>
                                        <Option value="ELeprechaun.swf~ELeprechaun">Evolved Leprechaun Armor</option>
                                        <Option value="SolarfluxMiltonius_skin.swf~SolarfluxMiltonius">Evolved Solarflux</option>
                                        <Option value="ExoSkin.swf~ExoSkin">ExoSkin</option>
                                        <Option value="FantasyBard_skin.swf~FantasyBard">Fantasy Bard</option>
                                        <Option value="FatPanda.swf~FatPanda">Fat Panda</option>
                                        <Option value="Fear.swf~Fear">Fear's Garb</option>
                                        <Option value="DageScareCrow.swf~DageScareCrow">Field Guardian</option>
                                        <Option value="demon3b_skin.swf~Demon3b">Fiend Carapace Armor</option>
                                        <Option value="MiltonPool4_skin.swf~MiltonPool4">Fiend of Miltonius</option>
                                        <Option value="warrior6_skin.swf~Warrior6">Fighter Armor</option>
                                        <Option value="Fairy1_skin.swf~Fairy1">Forest Faerie Dress[F]</option>
                                        <Option value="FormalMage.swf~FormalMage">Formal Mage Robes</option>
                                        <Option value="FormalWarrior.swf~FormalWarrior">Formal Void Warrior</option>
                                        <Option value="draconian2_skin.swf~draconian2">Frost Draconian</option>
                                        <Option value="GarthMaul.swf~GarthMaul">Garth Maul</option>
                                        <Option value="GateKeeper.swf~GateKeeper">Gate Keeper</option>
                                        <Option value="Gatorguy.swf~Gatorguy">Gatorguy</option>
                                        <Option value="ghost_skin.swf~Ghost">Ghost</option>
                                        <Option value="Tinsel01_skin.swf~Tinsel01">Glacier Garment</option>
                                        <Option value="GamerArmor.swf~GamerArmor">GodMode GamerArmor</option>
                                        <Option value="sepulchure4_skin.swf~Sepulchure4">Gold DoomKnight Armor</option>
                                        <Option value="MoglinGold_skin.swf~MoglinGold">Golden Moglin Suit</option>
                                        <Option value="GoldenPlate.swf~GoldenPlate">Golden Plate</option>
                                        <Option value="GoldenWar1_skin.swf~GoldenWar1">Golden Warrior</option>
                                        <Option value="golf_skin.swf~Golf">Golf Suit</option>
                                        <Option value="Gourdian.swf~Gourdian">Gourdian</option>
                                        <Option value="Grand1_skin.swf~Grand1">Grand Inquisitor Armor</option>
                                        <Option value="Dwarf1_skin.swf~Dwarf1">Grand Master Ironcrusher</option>
                                        <Option value="gravity_skin.swf~Gravity1">Gravity Overlord Armor</option>
                                        <Option value="draconian1_skin.swf~Drac1">Green Draconian</option>
                                        <Option value="Demon2Green_skin.swf~Demon2Green">Green Symbiote ~ Watcher Green</option>
                                        <Option value="football1_skin.swf~Football1">Grid Iron Death Team.</option>
                                        <Option value="groom_skin.swf ~Groom">Groom</option>
                                        <Option value="guardian_skin.swf~Guardian">Guardian Armor</option>
                                        <Option value="J6Sketch_skin.swf~J6Sketch">Hand-Drawn J6 Armor</option>
                                        <Option value="MiltonPool2_skin.swf~MiltonPool2">Hex of Miltonius</option>
                                        <Option value="green_skin.swf~Green">Hitchgreen's Costume</option>
                                        <Option value="HolidayCaster.swf~HolidayCaster">Holiday Caster</option>
                                        <Option value="jester1_skin.swf~Jester1">Holiday Jester</option>
                                        <Option value="Hollow.swf~Hollow">Hollow Revenant</option>
                                        <Option value="HollowZerker.swf~HollowZerker">Hollow Zerker</option>
                                        <Option value="Hollowsoul_skin.swf~Hollowsoul">Hollowsoul Knight</option>
                                        <Option value="twinsMiltonPool3_skin.swf~twinsMiltonPool3">Hot Girl</option>
                                        <Option value="hydra1_skin.swf~Hydra1">Hydra Armor</option>
                                        <Option value="IcyDavy_skin.swf~IcyDavy1">Icy Naval Commander</option>
                                        <Option value="warrior1a_skin.swf~Warrior1">Imperial Plate Armor</option>
                                        <Option value="Irismancer_skin.swf~Irismancer">Irismancer</option>
                                        <Option value="Screw1_skin.swf~Screw1">Iron Bolt Armor</option>
                                        <Option value="undead2_skin.swf~Undead2">Iron Bones</option>
                                        <Option value="warrior8_skin.swf~Warrior8">Ironhide Plate</option>
                                        <Option value="J6_Skin.swf~J6">J6 Armor</option>
                                        <Option value="J6Knight.swf~J6Knight">J6 Knight</option>
                                        <Option value="J6Samurai.swf~J6Samurai">J6 Samurai</option>
                                        <Option value="J6Pirate.swf~J6Pirate">J6 ~ Pirate</option>
                                        <Option value="J6Mech.swf~J6Mech">J6's Birthday Suit</option>
                                        <Option value="J6V1_skin.swf~J6V1">J6V1</option>
                                        <Option value="Jemini_skin.swf~Jemini">Jemini's Armor[F]</option>
                                        <Option value="Jester3_skin.swf~Jester3">Jester Outfit</option>
                                        <Option value="santa3_skin.swf~Santa3">Jolly Frostval Attire</option>
                                        <Option value="KISS_skin.swf~KISS">K.I.S.S Armor</option>
                                        <Option value="Kahli.swf~Kahli">Kalestri Worshiper</option>
                                        <Option value="king_skin.swf~King">King Armor</option>
                                        <Option value="KingCoal_skin.swf~KingCoal">King Coal's Armor</option>
                                        <Option value="Koi.swf~Koi">Koi's Armor</option>
                                        <Option value="Ezio_skin.swf~Ezio">Koi's Ezio Armor</option>
                                        <Option value="Korin_skin.swf~Korin">Korin's Armor</option>
                                        <Option value="Kosefira_skin.swf~Kose">Kosefira's Armor</option>
                                        <Option value="max_skin.swf~Max">Kreath's Armor </option>
                                        <Option value="LakenFormalSuit.swf~LakenFormalSuit">Laken Formal Suit</option>
                                        <Option value="Lavamancer.swf~Lavamancer">Lavamancer</option>
                                        <Option value="Lavitz_skin.swf~Lavitz">Lavitz Viking Armor</option>
                                        <Option value="Chaosplant1_skin.swf~Chaosplant1">Ledgermayne Skin</option>
                                        <Option value="Leprechaun_skin.swf~Leprechaun">Leprechaun Class</option>
                                        <Option value="mage3_skin.swf~Mage3">Lich</option>
                                        <Option value="Lim_skin.swf~Lim">Lim's Armor</option>
                                        <Option value="llussion_Skin2.swf~llussion">Llussion's Armor</option>
                                        <Option value="LumberTurkey_skin.swf~LumberTurkey">Lumberjack Turkey</option>
                                        <Option value="Lunar1_skin.swf~Lunar1">Lunaris Sentinel</option>
                                        <Option value="Lycan1_skin.swf~Lycan1">Lycan Knight</option>
                                        <Option value="Lycan3_skin.swf~Lycan3">Lycan Transformation[clickable]</option>
                                        <Option value="mage_skin.swf~Mage">Mage Class</option>
                                        <Option value="MiltonPoolMageLord_skin.swf~MageLord">Magelord</option>
                                        <Option value="MiltonPoolFire2_skin.swf~MiltonPoolFire2">Magma Armor</option>
                                        <Option value="Magnetic.swf~Magnetic">Magnetic Plate</option>
                                        <Option value="AK1.swf~AK1">Malani Warrior</option>
                                        <Option value="mariachi_skin.swf~Mariachi">Mariachi Armor</option>
                                        <Option value="Maxmillian_skin.swf~Maximillian">Maximillian Armor</option>
                                        <Option value="Nazgul.swf~Nazgul">Mennace's Nazgul</option>
                                        <Option value="MiltoniusPoolCC_skin.swf~MiltoniusPool2">Miltonius Color-custom</option>
                                        <Option value="MiltonPool1_skin.swf~MiltonPool1">Miltonius's Armor</option>
                                        <Option value="Miltonius2_skin.swf~Miltonius2">Miltonius</option>
                                        <Option value="MiltonPoolGood1_skin.swf~MiltonPoolGood1">Mirror Drakath</option>
                                        <Option value="MoglinDefender.swf~MoglinDefender">Moglin Defender</option>
                                        <Option value="Mummy_skin.swf~Mummy">Mummy</option>
                                        <Option value="MusicPirate_skin.swf~MusicPirate">Music Pirate Garb</option>
                                        <Option value="Irismancer_skin.swf~Irismancer">Mysterious Armor</option>
                                        <Option value="magemystic_skin.swf~magemystic">Mystic Mage</option>
                                        <Option value="indian1_skin.swf~Indian1">Native Warrior</option>
                                        <Option value="Hook_skin.swf~Hook1">Naval Commander</option>
                                        <Option value="DarkCaster2.swf~DarkCaster2">Necro CC</option>
                                        <Option value="NecroCheer2.swf~NecroCheer">Necro U Cheerleader</option>
                                        <Option value="NecroAlt.swf~NecroAlt">Necrolock</option>
                                        <Option value="Necro2_skin.swf~Necro2">Necromancer 2</option>
                                        <Option value="Necro1_skin.swf~Necro1">Necromancer</option>
                                        <Option value="Armor_Temp.swf~Armor_Temp">Newbie Armor</option>
                                        <Option value="nemesis_skin.swf~Nemesis">Nightmare Plate</option>
                                        <Option value="ninja_skin.swf~Ninja">Ninja</option>
                                        <Option value="Ghost2_skin.swf~Ghost2">No Body Morph</option>
                                        <Option value="ninjaNOTruto_skin.swf~ninjaNOTruto">NOTruto Garb</option>
                                        <Option value="MiltoniusNulgath1_skin.swf~MiltoniusNulgath1">Nulgath Armour</option>
                                        <Option value="Nythera_skin.swf~Nythera">Nythera Armor</option>
                                        <Option value="odanata_skin.swf~Odanata">Odanata Skin [F]</option>
                                        <Option value="Kimberly.swf~Kimberly">One-Eyed Doll Armor[M/F Look]</option>
                                        <Option value="DollArmor.swf~DollArmor">One-Eyed Warrior</option>
                                        <Option value="sepulchure3_skin.swf~Sepulchure3">Onyx DoomKnight Armor</option>
                                        <Option value="sepulchure2_skin.swf~Sepulchure2">Ornate DoomKnight Armor</option>
                                        <Option value="knight_skin.swf~Knight">Pactagonal Knight</option>
                                        <Option value="GoldSilverPally.swf~GoldSilverPally">Paladin of Resolution</option>
                                        <Option value="Panda1_skin.swf~Panda1">Panda</option>
                                        <Option value="peacock_skin.swf~Peacock">Peacock's Costume</option>
                                        <Option value="peasant_skin.swf~Peasant">Peasant Rags</option>
                                        <Option value="paladin3_skin.swf~Paladin3">Pepto-Paladin</option>
                                        <Option value="warrior9_skin.swf~Warrior9">Phoenix Plate</option>
                                        <Option value="pilgrimmage_skin.swf~pilgrimmage">Pilgrim Wizard</option>
                                        <Option value="NinjaPink.swf~NinjaPink">Pink Ninja</option>
                                        <Option value="PinkRogue_skin.swf~PinkRogue">Pink Rogue Armor</option>
                                        <Option value="pirate3_skin.swf~Pirate3">Pirate Captain </option>
                                        <Option value="PlatinumKnight_skin.swf~PlatinumKnight">Platinum Knight</option>
                                        <Option value="PolistarV2.swf~PolistarV2">Polistar Armor V2</option>
                                        <Option value="Polistar.swf~Polistar">Polistar Armor</option>
                                        <Option value="toilet1_skin.swf~Toilet1">Port-A-Pwnzor</option>
                                        <Option value="potatosack_skin.swf~Potatosack">Potato Sack</option>
                                        <Option value="SepulchurePink_skin.swf~SepulchurePink">Pretty in Pink DoomKnight</option>
                                        <Option value="Composer2_skin.swf~Composer2">Prismatic Composer Armor</option>
                                        <Option value="draconian3_skin.swf~DracCC">Prismatic Draconian</option>
                                        <Option value="Karate2_skin.swf~Karate2">Prismatic Karategi</option>
                                        <Option value="WizardCC.swf~WizardCC">Prismatic Magi Robes</option>
                                        <Option value="Prometheus2.swf~Prometheus2">Prometheus v2</option>
                                        <Option value="Prometheus.swf~Prometheus">Prometheus</option>
                                        <Option value="Vic1.swf~Vic1">Proper Victorian Garb</option>
                                        <Option value="Mech2_skin.swf~Mech2">Protosartorium</option>
                                        <Option value="pumpkinlord_skin.swf~Pumpkinlord">Pumpkin Lord</option>
                                        <Option value="queen_skin.swf~Queen">Queen's Robe [F]</option>
                                        <Option value="RA.swf~Ra">Ra Armor</option>
                                        <Option value="rtr_dev-skin.swf~Randor">Randor The Red's Armor</option>
                                        <Option value="Ranger4_skin.swf~Ranger4">Ranger Four</option>
                                        <Option value="Ranger1_skin.swf~Ranger1">Ranger One</option>
                                        <Option value="Ranger3_skin.swf~Ranger3">Ranger Three</option>
                                        <Option value="Ranger2_skin.swf~Ranger2">Ranger Two</option>
                                        <Option value="Recycled.swf~Recycle">Recycled Armor</option>
                                        <Option value="Dwarfred3_skin.swf~Dwarfred3_skin">Red Dwarf Warrior Armor</option>
                                        <Option value="demon3_skin.swf~Demon3">Red Fiend Morph</option>
                                        <Option value="moglin1_skin.swf~Moglin1">Red Moglin Suit</option>
                                        <Option value="VoltaboltRed_skin.swf~VoltaboltRed">Red Voltabolt Coat</option>
                                        <Option value="Reens.swf~Reens">Reens' Alchemist [F]</option>
                                        <Option value="reens_skin.swf~Reens">Reens' Skin [F]</option>
                                        <Option value="StealthVSlayer_skin.swf~Stealth">Reens' Vampire Slayer [F]</option>
                                        <Option value="Rogue5_skin.swf~Rogue5">Renegade</option>
                                        <Option value="RiftWarden.swf~RiftWarden">Rift Warden</option>
                                        <Option value="graduation_skin.swf~Graduation">Robe of Knowledge</option>
                                        <Option value="Rayst_skin.swf~Rayst">Robes of Rayst</option>
                                        <Option value="rogue6_skin.swf~Rogue6">Rogue Six [F]</option>
                                        <Option value="Rogue3_skin.swf~Rogue3">Rogue Three</option>
                                        <Option value="Rogue2_skin.swf~Rogue2">Rogue Two</option>
                                        <Option value="rolith_skin.swf~Rolith">Rolith's Armor</option>
                                        <Option value="Davy_skin.swf~Davy1">Rotting Naval Commander</option>
                                        <Option value="PotionWizard_skin.swf~PotionWizard">Royal Alchemist</option>
                                        <Option value="RoyalFalconeer_skin.swf~RoyalFalconeer">Royal Falconeer</option>
                                        <Option value="RoyalOffice.swf~RoyalOffice">Royal Romance Garb</option>
                                        <Option value="royalsuit_skin.swf~Royalsuit">Royal Suit</option>
                                        <Option value="TinMan.swf~TinMan">Rust Man</option>
                                        <Option value="mech2a_skin.swf~Mech2a">Rustbucket Class</option>
                                        <Option value="Ryuuji.swf~Ryuuji">Ryuuji</option>
                                        <Option value="barbarian1_skin.swf~Barbarian1">Samarian</option>
                                        <Option value="Samurai2_skin.swf~Samurai2">Samurai Armor</option>
                                        <Option value="SandArmor.swf~SandArmor">Sandrunner</option>
                                        <Option value="MoglinClaws_skin.swf~MoglinClaws">Santy Claws Moglin Suit</option>
                                        <Option value="War1armor1_skin.swf~Warlord1">Savage Warlord</option>
                                        <Option value="SekDuat_skin.swf~SekDuat">Sek-Duat</option>
                                        <Option value="sepulchure_skin.swf~Sepulchure">Sepulchure</option>
                                        <Option value="shadowcleric_skin.swf~Shadowcleric">Shadow Cleric</option>
                                        <Option value="Armor2_skin.swf~Armor2">Shadow Guard</option>
                                        <Option value="undead2a_skin.swf~Undead2a">Shadow Lich</option>
                                        <Option value="MiltonPool5_skin.swf~MiltonPool5">Shadow of Miltonius</option>
                                        <Option value="ninja4_skin.swf~ninja4">Shadow Shinobi</option>
                                        <Option value="Baron1_skin.swf~Baron1">Shadow Weaver</option>
                                        <Option value="Shadowwarrior1_skin.swf~Shadowwarrior1">Shadowscythe Reaver</option>
                                        <Option value="VSlayer_skin.swf~VSlayer">Shadowslayer Armor</option>
                                        <Option value="MiltonPoolShamanClass_skin.swf~ShamanClass">Shaman Class</option>
                                        <Option value="Fishman_skin.swf~Sharkman">SharkBait's Armor</option>
                                        <Option value="Greek2_skin.swf~Greek2">Shielded Centurion Armor</option>
                                        <Option value="mech3_skin.swf~Mech3">Skull Crusher</option>
                                        <Option value="SGPrivate.swf~SGPrivate">Skyguard Private</option>
                                        <Option value="SkyGuard.swf~SkyGuard">Skyguard Uniform</option>
                                        <Option value="Sneevilmachine_skin.swf~Sneevilmachine">Sneeviltron</option>
                                        <Option value="Snowman.swf~Snowman">Snowman</option>
                                        <Option value="SnuggleBear1_skin.swf~Snugbear2">Snuggle Bear</option>
                                        <Option value="Solar1_skin.swf~Solar1">Solaris Knight</option>
                                        <Option value="Mage2_skin.swf~Mage2">Sorceror</option>
                                        <Option value="Gressil_skin.swf~Gressil">Souleater Warrior</option>
                                        <Option value="spartan1_skin.swf~Spartan1">Spartan Warrior</option>
                                        <Option value="mech4_skin.swf~Mech4">StarLord Armor</option>
                                        <Option value="PaladinStone.swf~PaladinStone">Stone Paladin Armor</option>
                                        <Option value="Storm.swf~Storm">Storm</option>
                                        <Option value="twinsMiltonPoolSun_skin.swf~twinsMiltonPoolSun">Sun Girl</option>
                                        <Option value="Swordhaven1_skin.swf~Swordhaven1">Swordhaven Adept</option>
                                        <Option value="demon2_skin.swf~Demon2">Symbiote</option>
                                        <Option value="T800.swf~T800">T-421</option>
                                        <Option value="TacoArmor.swf~TacoArmor">Tacomancer Armor</option>
                                        <Option value="LionMan.swf~LionMan">Territorial Lion</option>
                                        <Option value="thyton_skin.swf~Thyton">Thyton's Armor</option>
                                        <Option value="Tibi1_skin.swf~Tibi1">Tibicenas</option>
                                        <Option value="Tiger01_skin.swf~Tiger01_skin">Tiger Skin</option>
                                        <Option value="toga_skin.swf~Toga1">Toga</option>
                                        <Option value="Tomix_skin.swf~Tomix">Tomix's Armor</option>
                                        <Option value="MoglinPink.swf~MoglinPink">Totally Pink Moglin Morph</option>
                                        <Option value="TurD.swf~TurD">Turdraken Scale Armor</option>
                                        <Option value="mage-water.swf~MageWater">Typhoon Robe</option>
                                        <Option value="undead3_skin.swf~Undead3">Undead Berserker</option>
                                        <Option value="UndeadChampion.swf~UndeadChampion">Undead Champion</option>
                                        <Option value="undead1_skin.swf~Undead1">Undead Curse</option>
                                        <Option value="UndeadOverLord.swf~UndeadOverLord">Undead Legion OverLord</option>
                                        <Option value="UndeadOverLord.swf~UndeadOverLord">Undead OverLord</option>
                                        <Option value="undeadpaladin_skin.swf~UndeadPaladin">Undead Paladin</option>
                                        <Option value="undead4_skin.swf~Undead4">Undead Pirate Curse</option>
                                        <Option value="UndeadTerror1_skin.swf~UndeadTerror1">Undead Terror Armor</option>
                                        <Option value="UndeadGodDage.swf~UndeadGodDage">Undead Warrior</option>
                                        <Option value="Uw3010.swf~Uw3010">Uw3010</option>
                                        <Option value="dracula2_skin.swf~Dracula2">Vampire Armor</option>
                                        <Option value="dracula_skin.swf~Dracula">Vampire Class</option>
                                        <Option value="vamp1_skin.swf~vamp1">Vampire Emissary</option>
                                        <Option value="vamp2_skin.swf~vamp2">Vampire Knight</option>
                                        <Option value="VampLord.swf~VampLord">Vampire Lord Incubus</option>
                                        <Option value="vamp3_skin.swf~vamp3">Vampire Transformation[clickable]</option>
                                        <Option value="Vath1_skin.swf~Vath1">Vath's Chaotic Dragonlord Armor</option>
                                        <Option value="VileVulture.swf~VileVulture">Vile Vulture</option>
                                        <Option value="Mountaineer02_skin.swf~Mountaineer02">Vivid Mountaineer</option>
                                        <Option value="Void.swf~Void">Void Entity</option>
                                        <Option value="Voltabolt_skin.swf~Voltabolt">Voltabolt Coat </option>
                                        <Option value="WarMummySkin.swf~WarMummySkin">War Mummy Armor</option>
                                        <Option value="Armor1A_skin.swf~Armor1A">Warden of Light</option>
                                        <Option value="Warlic_skin.swf~Warlic">Warlic the Red</option>
                                        <Option value="warrior4_skin.swf~Warrior4">Warlord Class</option>
                                        <Option value="MiltonPoolAlpha2_skin.swf~MiltonPoolLock1">Warlord of Miltonius</option>
                                        <Option value="heavygunner_skin2.swf~WFHG">WarpForce Heavygunner Armor</option>
                                        <Option value="warrior_skin.swf~Warrior">Warrior</option>
                                        <Option value="Samurai1_skin.swf~Samurai1">White Samurai Robe</option>
                                        <Option value="WhiteWitchWarlock.swf~WhiteWitchWarlock">White Witch and Warlock</option>
                                        <Option value="darkwitch2_skin.swf~Darkwitch2">Witch Armor</option>
                                        <Option value="darkwitch_skin.swf~Darkwitch">Witch</option>
                                        <Option value="Wyrm_skin.swf~Wyrm">Wyrm's Armor</option>
                                        <Option value="Xusha.swf~Xusha">Xusha's Curse</option>
                                        <Option value="EvilRabbit.swf~EvilRabbit">Year of the Rabbit Warrior</option>
                                        <Option value="Kitsune_skin.swf~Kitsune1">Youkono</option>
                                        <Option value="Xbox_skin.swf~Xbox">Zeke</option>
                                        <Option value="zhoom_skin.swf~Zhoom">Zhoom's Armor</option>
                                        <Option style="text-decoration: line-through;color: red;" value="Zombie.swf~Zombie">Zombification</option>
                                        <Option value="-">|_____________________________________|</option>
                                        <Option value="undead5_skin.swf~Undead5">NEEDS NAME - Undead Armor 2</option>
                                        <Option value="Zheenx.swf~Zheenx">Zheenx's Armor</option>
                                        <Option value="">|</option>
                                        <Option value="SteamGear-19Jul11.swf~SteamGear">SteamGear Armor</option>
                                        <Option value="OmegaAlchemist.swf~OmegaAlchemist">Omega Alchemist</option>
                                        <Option value="AssaultGear.swf~AssaultGear">Assault Gear</option>
                                        <Option value="MechD.swf~MechD">Mecha Defender</option>
                                        <Option value="Infiltrator1.swf~Infiltrator">Infiltrator</option>
                                        <Option value="Hunter.swf~Hunter">Hunter</option>
                                        <Option value="DeathDealer.swf~DeathDealer">Death Dealer</option>
                                        <Option value="HeartlessCrossBerserker.swf~HeartlessCrossBerserker">Heartless Cross Berserker</option>
                                        <Option value="ShadowBorn.swf~ShadowBorn">Shadow Born</option>
                                        <Option value="NecroSnake.swf~NecroSnake">Necro Snake Armor</option>
                                        <Option value="Darkness.swf~Darkness">Darkness</option>
                                        <Option value="TeslaMage.swf~TeslaMage">Techno Mage</option>
                                        <Option value="Rage.swf~Rage">Rage</option>
                                        <Option value="EvolvedShawman.swf~EvolvedShawman">Evolved Shaman Class</option>
                                        <Option value="Tombstone.swf~Tombstone">Tombstone Armor</option>
                                        <Option value="UndeadSlayer.swf~UndeadSlayer">Undead Slayer Class</option>
                                        <Option value="LegionReaper.swf~LegionReaper">Soul Harvester</option>
                                    </SELECT></td>
                            </tr>
                            <tr>
                                <td><b><img src="images/weapon.png" width="15px" /> Weapon:</b></td>
                                <td style="display:none;"><input onChange="javascript:ChangeItem('weapon')" type="text" name="wepfile" value="<?php echo $weaponfile; ?>"></td>
                                <td style="display:none;"><input onChange="javascript:ChangeItem('weapon')" type="text" name="weplink" value="<?php echo $weaponlink; ?>"></td>
                                <td style="display:none;"><input onChange="javascript:ChangeItem('weapon')" type="text" name="wepname" value="<?php echo $weaponname; ?>"></td>
                                <td><select id="weapon" onChange="javascript:ChangeItem('weapon')" NAME="WeaponSelect">
                                        <Option value="items/axes/axe05.swf-">Blinding Light of Destiny</option>
                                        <Option value="items/axes/13thaxe01.swf-13thaxe01.swf">13 Leaf Clover Axe</option>
                                        <Option value="items/swords/firstBDaySword.swf-firstBDaySword">1st Birthday Sword</option>
                                        <Option value="items/axes/SpiderQuibaxe01.swf-SpiderQuibaxe01">Abaddon's Orb Weaver Axe</option>
                                        <Option value="items/polearms/SpiderQuibpolearm01.swf-SpiderQuibpolearm01">Abaddon's Terror</option>
                                        <Option value="items/daggers/LedgeBookShield.swf-LedgeBookShield">Academic Acoutrements</option>
                                        <Option value="items/swords/newbiesword2.swf-">Adventurers Sword</option>
                                        <Option value="items/staves/aelstaff.swf-">Aelthai's Staff</option>"></option>
                                        <Option value="items/guns/PotionRifle.swf-PotionRifle">Alchemist's Rifle</option>
                                        <Option value="items/staves/Surf2Alina2011.swf-SurfAlina11">Alina Surfboard</option>
                                        <Option value="items/swords/sword48.swf-">Amethyst Claymore</option>
                                        <Option value="items/daggers/AmonRaDaggers.swf-AmonRaDaggers">Amon Ra Daggers</option>
                                        <Option value="items/swords/AncientDismalClaymore.swf-AncientDismalClaymore">Ancient Dismal Claymore</option>
                                        <Option value="items/swords/AncientSkullBlade.swf-AncientSkullBlade">Ancient Skull Blade</option>
                                        <Option value="items/axes/Barbarianaxe01.swf-">Angel Axe of Light</option>
                                        <Option value="items/swords/AngelicRunedBroadsword1.swf-AngelicRunedBroadsword1">Angelic Runed Broadsword</option>
                                        <Option value="items/staves/staff_angel.swf-staff_angel">Angelique Staff</option>
                                        <Option value="items/staves/AppollonirsBeastClaw.swf-AppollonirsBeastClaw">Appollonir's Beast Claw</option>
                                        <Option value="items/daggers/Diploma1.swf-">AQW Diploma</option>
                                        <Option value="items/bows/SpiderQuibbow01.swf-SpiderQuibbow01">Arachno Bow</option>
                                        <Option value="items/staves/staffMageTrainer.swf-">Arcana's Disciple</option>
                                        <Option value="items/daggers/MiltonPoolTalon02.swf-">Arm Blades Of Miltonius</option>
                                        <Option value="items/staves/Surf2Artix2011.swf-SurfArtix11">Artix! Surfboard</option>
                                        <Option value="items/axes/axe-aprilfools.swf-">Artix's ScribbleAxe</option>
                                        <Option value="items/staves/AstralMetalScythe.swf-AstralMetalScythe">Astral Scythe of Lilith</option>
                                        <Option value="items/daggers/AstralStingers.swf-AstralStingers">Astral Stingers</option>
                                        <Option value="items/daggers/AtomosSwordShield.swf-AtomosSwordShield">Atomosian Armaments</option>
                                        <Option value="items/swords/ElevenSword.swf-ElevenSword">Auld Lang Syne Sword</option>
                                        <Option value="items/axes/OneEyeDollAxe.swf-OneEyeDollAxe">Axe Me Nicely</option>
                                        <Option value="items/axes/DrowAxe01.swf-">Axe of Hauberk</option>
                                        <Option value="items/axes/AxeofMinar.swf-AxeofMinar">Axe of Minar</option>
                                        <Option value="items/swords/Playersword01.swf-Playersword01">Backbreaker</option>
                                        <Option value="items/axes/BallyhooAxe.swf-BallyhooAxe">Ballyhoo's Axe</option>
                                        <Option value="items/swords/sword20.swf-">Balrog Blade </option>
                                        <Option value="items/swords/Nanersword1.swf-Nanersword1">Banana Thorn Blade </option>
                                        <Option value="items/swords/MiltonPoolsword07.swf-MiltonPoolsword07">Bane of Miltonius</option>
                                        <Option value="items/swords/Darksword01.swf-">Barbaric Blade of Darkness</option>
                                        <Option value="items/swords/sword05.swf-">Barbed Horror</option>
                                        <Option value="items/daggers/BasicSai.swf-">Basic Sai</option>
                                        <Option value="items/bows/BassClefBow.swf-BassClefBow">Bass Clef Bow</option>
                                        <Option value="items/swords/BatBlade.swf-BatBlade">Bat Broad Blade</option>
                                        <Option value="items/daggers/PianoBattleStriker2.swf-PianoBattleStriker2">Battle Piano Strikers</option>
                                        <Option value="items/axes/dwarfaxe4.swf-">Battleaxe of the Angaz</option>
                                        <Option value="items/maces/SpatulaBBQSword.swf-">BBQ Spatula</option>
                                        <Option value="items/staves/staff20.swf-">Beacon Staff</option>
                                        <Option value="items/polearms/Tridentweapon2.swf-">Beast of Pirate's Bay Trident</option>
                                        <Option value="items/swords/Jeweledblade1.swf-">Bejeweled Blade</option>
                                        <Option value="items/staves/Surf2Beleen2011.swf-SurfBeleen11">Beleen Surfboard</option>
                                        <Option value="items/swords/sword03.swf-">Big 100K</option>
                                        <Option value="items/swords/player1.swf-">Big Daddy</option>
                                        <Option value="items/swords/BOA16bit.swf-BOA16bit">Blade Of 16 Bit Awe</option>
                                        <Option value="items/swords/BOA16bit.swf-BOA16bit">Blade of 16-Bit Awe</option>
                                        <Option value="items/swords/MiltonPoolsword04.swf-">Blade of Affliction</option>
                                        <Option value="items/swords/AltBlade.swf-AltBlade">Blade of Alt</option>
                                        <Option value="items/swords/sword12.swf-">Blade of Awe</option>
                                        <Option value="items/swords/CursedShadowBlade.swf-CursedShadowBlade">Blade of Cursed Shadow</option>
                                        <Option value="items/swords/BladeOfDerp.swf-BladeOfDerp">Blade Of Derp</option>
                                        <Option value="items/swords/sword10.swf-">Blade of Destiny</option>
                                        <Option value="items/swords/BladeofHalfAwef.swf-BladeofHalfAwef">Blade of Half Awe-f</option>
                                        <Option value="items/swords/DrowSword01.swf-">Blade of Khopesh</option>
                                        <Option value="items/swords/GhostSword.swf-GhostSword">Blade of Revenant</option>
                                        <Option value="items/swords/PharohsKrisBlade.swf-PharohsKrisBlade">Blade of the Desert Dunes</option>
                                        <Option value="items/swords/RapierOfTheGemmedHeart.swf-RapierOfTheGemmedHeart">Blade of the Gemmed Heart</option>
                                        <Option value="items/swords/sword05b.swf-">Blade of Thorns</option>
                                        <Option value="items/swords/sword05c.swf-sword05c">Blade Of Vampire</option>
                                        <Option value="items/daggers/BladesofCorruption.swf-BladesofCorruption">Blades Of Corruption</option>
                                        <Option value="items/axes/Chaosaxe01.swf-">Blinding Light of Chaos</option>
                                        <Option value="items/swords/chainsaw2.swf-BlisterSaw">Blister's Chainsaw</option>
                                        <Option value="items/swords/VampiresBlaze.swf-VampiresBlaze">Blood Blaze of the Vampire</option>
                                        <Option value="items/swords/EvilSword03.swf-EvilSword03">Blooddrop Slasher</option>
                                        <Option value="items/swords/Bloodgroove1.swf-Bloodgroove1">Bloodgroove</option>
                                        <Option value="items/swords/MiltonPoolKatanasword01.swf-MiltonPoolKatanasword01">Bloodletter of Miltonius</option>
                                        <Option value="items/swords/Ballysword1.swf-Ballysword1">Bloodriver</option>
                                        <Option value="items/staves/Glowstick3.swf-">Blue GlowStick</option>
                                        <Option value="items/staves/staff04.swf-">Blue Light Staff</option>
                                        <Option value="items/swords/BlueSkyWeap.swf-BlueSkyWeap">Blue Sky Weapon</option>
                                        <Option value="items/swords/sword23.swf-">Blue Starsword</option>
                                        <Option value="items/staves/bostaff.swf-">Bo Staff</option>
                                        <Option value="items/swords/HolidayBlade2.swf-HolidayBlade2">Bom Velhinho Blade</option>
                                        <Option value="items/staves/BoneClawsofTurmoil.swf-BoneClawsofTurmoil">Bone Claws of Turmoil</option>
                                        <Option value="items/swords/sword07.swf-">Bone Sword</option>
                                        <Option value="items/maces/BoomBox.swf-BoomBox">Boom Box</option>
                                        <Option value="items/swords/AncientBlade1.swf-AncientBlade1">Bound Sword of Serekh</option>
                                        <Option value="items/axes/Voltaireguitar4.swf-Voltaireguitar4">Braken Bass</option>
                                        <Option value="items/maces/pallymace1.swf ">Brightskull of Retribution</option>
                                        <Option value="items/swords/BroadWerepyrebladeMog.swf-BroadWerepyrebladeMog">Broad Moglow Blades</option>
                                        <Option value="items/swords/sword19.swf-">Broad Sword</option>
                                        <Option value="items/daggers/Brokenbottle.swf-Brokenbottle">Broken Bottle</option>
                                        <Option value="items/staves/13thstaff01.swf-13thstaff01">Broken Mirror of Death</option>
                                        <Option value="items/staves/Broom.swf-">Broom</option>
                                        <Option value="items/swords/sword17.swf-">Brutal Sword</option>
                                        <Option value="items/maces/Tonfa3.swf-Tonfa3">Brutal Tonfa</option>
                                        <Option value="items/swords/ButerLineofSouls.swf-ButerLineofSouls">Busterline of Souls</option>
                                        <Option value="items/daggers/knife01.swf-">Butcher Knife</option>
                                        <Option value="items/staves/candycane1.swf-candycane1">Candy Cane [2]</option>
                                        <Option value="items/staves/CandyCane.swf-">Candy Cane</option>
                                        <Option value="items/staves/moneystaff01.swf ">Cane of Greed</option>
                                        <Option value="items/swords/Starcaptainsword1.swf-">Captain's Plasma Blade</option>
                                        <Option value="items/daggers/CardBlades.swf-CardBlades">Card Blades</option>
                                        <Option value="items/swords/CardboardSword.swf-CardboardSword">Cardboard Sword</option>
                                        <Option value="items/axes/OrnateDarkBattleAxe.swf-OrnateDarkBattleAxe">Cataclysmic Gilead Axe</option>
                                        <Option value="items/axes/CelestialSandAxe.swf-CelestialSandAxe">Celestial Sand Axe</option>
                                        <Option value="items/polearms/CelSandSpear.swf-CelSandSpear">Celestial SandSpear</option>
                                        <Option value="items/swords/CelSandSword.swf-CelSandSword">Celestial Sandsword</option>
                                        <Option value="items/swords/chainsaw1.swf-">Chainsaw</option>
                                        <Option value="items/swords/MiltonPoolPhoenixSword03.swf-MiltonPoolPhoenixSword03">Champion Blade of Miltonius</option>
                                        <Option value="items/swords/Hydrasword1.swf-">Champion Hydra Sword</option>
                                        <Option value="items/swords/Northlandssword01Chaos.swf-Northlandssword01Chaos">Chaorrupted Northland Blade</option>
                                        <Option value="items/staves/Dwarfholdstaff2.swf-">Chaorrupted Staff of the Twisted</option>
                                        <Option value="items/maces/VathMace01.swf-">Chaos Dragonlord Mace</option>
                                        <Option value="items/maces/Chaosmace1.swf-">Chaos Mace</option>
                                        <Option value="items/swords/ChaosShaperSword.swf-ChaosShaperSword">Chaos Shaper Sword</option>
                                        <Option value="items/swords/UltimusOmegus.swf-UltimusOmegus">Chaos Warrior Omegus</option>
                                        <Option value="items/polearms/Chaosspear01.swf-Chaosspear01">Chaotic Crystal Glaive</option>
                                        <Option value="items/swords/Hanzamunesword01Chaos.swf-Hanzamunesword01Chaos">Chaotic Hanzamune</option>
                                        <Option value="items/axes/ChaosAxe.swf-ChaosAxe">Chaotic Headsman's Axe</option>
                                        <Option value="items/polearms/ChaoticMusicNote.swf-ChaoticMusicNote">Chaotic Music Note</option>
                                        <Option value="items/polearms/Emperorpolearm1.swf-Emperorpolearm1">Chaotic Sumire Impaler</option>
                                        <Option value="items/maces/Chaosmace3.swf-">Chaotic Warrior Mace</option>
                                        <Option value="items/swords/WinterrorChaos.swf-WinterrorChaos">Chaotic Winterror</option>
                                        <Option value="items/swords/Xboxsword1.swf-Xboxsword1">Cheat Code Blade</option>
                                        <Option value="items/staves/ChineseUmbrella.swf-ChineseUmbrella">Chinese Umbrella</option>
                                        <Option value="items/polearms/UndeadPole1.swf-UndeadPole1">Chopping Pole Arm</option>
                                        <Option value="items/staves/circestaff.swf-">Circe's Staff</option>
                                        <Option value="items/staves/CitizenCane.swf-">Citizen's Kane</option>
                                        <Option value="items/daggers/MiltonPoolClaw01.swf-MiltonPoolClaw01">Claw of Miltonius</option>
                                        <Option value="items/daggers/AstralClaw.swf-AstralClaw">Claws of the Astral</option>
                                        <Option value="items/daggers/Wereclaws.swf-Wereclaws">Claws of the Weald</option>
                                        <Option value="items/swords/ClawSuitAdvancedSword.swf-ClawSuitAdvancedSword">Claws' Little Helper</option>
                                        <Option value="items/swords/CelticSword.swf-CelticSword">Claymore of the Celts</option>
                                        <Option value="items/axes/IcePick01.swf-IcePick01">Climber's Ice Pick</option>
                                        <Option value="items/polearms/UnleashedRage.swf-UnleashedRage">Clockwork Scythe</option>
                                        <Option value="items/swords/StPatty11Cleaver.swf-StPatty11Cleaver">Clover Chopper</option>
                                        <Option value="items/staves/Clydestaff.swf-Clydestaff">Clyde's Staff</option>
                                        <Option value="items/swords/CobaltSkyguardBlade.swf-CobaltSkyguardBlade">Cobalt Skyguard Blade</option>
                                        <Option value="items/staves/CobraStaff.swf-CobraStaff">Cobra's Serpentine Staff</option>
                                        <Option value="items/swords/CocktailSword.swf-CocktailSword">Cocktail Sword</option>
                                        <Option value="items/swords/coldruneedge.swf-">Cold Rune Edge</option>
                                        <Option value="items/guns/gun03.swf-">Colt Revolver</option>
                                        <Option value="items/guns/handgunj6.swf-">Colt Revolver</option>
                                        <Option value="items/swords/commercialsword1.swf-">Commercial Sword 1</option>
                                        <Option value="items/swords/commercialsword2.swf-">Commercial Sword 2</option>
                                        <Option value="items/swords/commercialsword3.swf-">Commercial Sword 3</option>
                                        <Option value="items/swords/commercialsword4.swf-">Commercial Sword 4</option>
                                        <Option value="items/swords/commercialsword5.swf-">Commercial Sword 5</option>
                                        <Option value="items/bows/bow01.swf-">Composite Bow</option>
                                        <Option value="items/swords/Cookiesword1.swf-Cookiesword1">Confectioner's Slayer</option>
                                        <Option value="items/swords/MiltonPoolsword05.swf-MiltonPoolsword05">Corpse Maker of Miltonius</option>
                                        <Option value="items/swords/CorruptedDragonSlayer.swf-CorruptedDragonSlayer">Corrupted Dragon Slayer</option>
                                        <Option value="items/swords/CorruptionBlade.swf-CorruptionBlade">Corruption Blade</option>
                                        <Option value="items/daggers/CourageSwordShield.swf-CourageSwordShield">Courage Armaments</option>
                                        <Option value="items/daggers/CreeperMiltoniusdagger01.swf-CreeperMiltoniusdagger01">Creeper Dagger</option>
                                        <Option value="items/staves/RedManaStaff.swf-RedManaStaff">Crimson Mana Staff</option>
                                        <Option value="items/swords/RoyalHearts.swf-RoyalHearts">Crimson Royal Hearts</option>
                                        <Option value="items/guns/VampGunBlade.swf-VampGunBlade">Crimson Sunderbuss</option>
                                        <Option value="items/swords/sword15.swf-">Crude Short Sword</option>
                                        <Option value="items/swords/Spidersword1.swf-">Cruel Chaos Widow Blade</option>
                                        <Option value="items/daggers/Claw03.swf-Claw03">Cruel Claw of Blizzard </option>
                                        <Option value="items/swords/guardsword01.swf-">Crusader Sword</option>
                                        <Option value="items/swords/Crystalclaymore01.swf-">Crystal Claymore</option>
                                        <Option value="items/swords/MiltonPoolPhoenixSword01.swf-MiltonPoolPhoenixSword01">Crystal Phoenix Blade of Miltonius</option>
                                        <Option value="items/staves/NovelCrystalRunedStaff.swf-NovelCrystalRunedStaff">Crystal Seed Runed Staff</option>
                                        <Option value="items/swords/GoodSword01.swf-GoodSword01">Crystaline Avastilator</option>
                                        <Option value="items/maces/GoodMace01.swf-GoodMace01">Crystaline Mallet</option>
                                        <Option value="items/staves/CrystalStaff.swf-CrystalStaff">Crystalline Staff</option>
                                        <Option value="items/staves/XboxControllerStave1.swf-XboxControllerStave1">CTRLler Staff</option>
                                        <Option value="items/maces/cuddlestick.swf-cuddlestick">Cuddlestick</option>
                                        <Option value="items/swords/CuniculusDecimator.swf-CuniculusDecimator">Cuniculus Decimator</option>
                                        <Option value="items/polearms/Fri13Fork2.swf-Fri13Fork2">Cursed Bident</option>
                                        <Option value="items/maces/CursedBoneClub.swf-CursedBoneClub">Cursed Bone Club</option>
                                        <Option value="items/swords/SkyCursdrgnblade.swf-SkyCursdrgnblade">Cursed Dragon Blade</option>
                                        <Option value="items/swords/CursedPharohsBlade.swf-CursedPharohsBlade">Cursed Pharaoh's Blades</option>
                                        <Option value="items/swords/CursedPharohsBlade.swf-CursedPharohsBlade">Cursed Pharaoh's Blades</option>
                                        <Option value="items/staves/CursedPharohsStaff.swf-CursedPharohsStaff">Cursed Pharaoh's Staff</option>
                                        <Option value="items/swords/CursedScimi.swf-CursedScimi">Cursed Scimitar</option>
                                        <Option value="items/swords/DragonSawBladeCC.swf-DragonSawBladeCC">Custom Dragonsaw Blade</option>
                                        <Option value="items/swords/TrooperSword1.swf-TrooperSword1">Custom Trooper Sword</option>
                                        <Option value="items/swords/GoldenCutlass.swf-">Cutlass Supreme</option>
                                        <Option value="items/swords/SimplePlantBlade.swf-SimplePlantBlade">Cypress Blade</option>
                                        <Option value="items/staves/Surf2Cy2011.swf-SurfCy11">Cysero Surfboard</option>
                                        <Option value="items/maces/Rolly16Bit.swf-Rolly16Bit">Cysero's 16-Bit Hammer</option>
                                        <Option value="items/maces/mug2.swf-mug2">Cysero's Berry Mug</option>
                                        <Option value="items/maces/mace04.swf-">Cysero's First Hammer</option>
                                        <Option value="items/maces/macegreen.swf-">Cysero's Hammer</option>
                                        <Option value="items/swords/DagesSoulKris.swf-DagesSoulKris">Dage's Soul Kris</option>
                                        <Option value="items/daggers/dagger02b.swf-">Dagger of Serpents</option>
                                        <Option value="items/daggers/BatDagger01.swf-">Dagger of the Bat</option>
                                        <Option value="items/daggers/NytherasDagger.swf-NytherasDagger">Daggers Of Dragonkin</option>
                                        <Option value="items/daggers/DaggerofRa.swf-DaggerofRa">Daggers of Ra</option>
                                        <Option value="items/polearms/DrowPolearm01.swf-">Daoi-Sith Halberd</option>
                                        <Option value="items/axes/Barbarianaxe02.swf-">Dark Angel Axe of Shadow</option>
                                        <Option value="items/swords/Crystalclaymore02.swf-">Dark Crystal Claymore</option>
                                        <Option value="items/axes/dblAxeBladeDark.swf-">Dark Double Axe Blade</option>
                                        <Option value="items/swords/dracsword2.swf-">Dark Draconian Sword</option>
                                        <Option value="items/daggers/BlackMoonDaggers.swf-BlackMoonDaggers">Dark Lunar Daggers</option>
                                        <Option value="items/staves/BlackMoonStaff.swf-BlackMoonStaff">Dark Moon Rising</option>
                                        <Option value="items/swords/PrismaticKatana.swf-PrismaticKatana">Dark Prismatic Katana</option>
                                        <Option value="items/swords/Runesword02.swf-">Dark Rune Sword</option>
                                        <Option value="items/swords/BlackMoonSword.swf-BlackMoonSword">Dark Solistice Sword</option>
                                        <Option value="items/staves/DarkTribalSkullStaff.swf-DarkTribalSkullStaff">Dark Tribe Skull Staff</option>
                                        <Option value="items/staves/WizardsDoom.swf-WizardsDoom">Dark Wizard's Disparage</option>
                                        <Option value="items/swords/MiltonPoolDdogsword01.swf-MiltonPoolDdogsword01">Ddog Sea Serpent Sword</option>
                                        <Option value="items/axes/Chaosaxe02.swf-">Deadly Axe of Chaos</option>
                                        <Option value="items/polearms/Elitepole01.swf-">Deadly Dragon Claw</option>
                                        <Option value="items/daggers/DeadlyFan.swf-DeadlyFan">Deadly Fan</option>
                                        <Option value="items/swords/Ironblade01.swf-">Deadly Tower Blade</option>
                                        <Option value="items/axes/ShadowAxe01.swf-">Death Eater Axe</option>
                                        <Option value="items/swords/dfasword.swf-dfasword">Death From Above</option>
                                        <Option value="items/daggers/MiltonPoolSecretdagger02.swf-MiltonPoolSecretdagger02">Death Scythe of Miltoius</option>
                                        <Option value="items/staves/DeathknightStaff.swf-DeathknightStaff">Deathknight Staff</option>
                                        <Option value="items/swords/DeathknightsReign.swf-DeathknightsReign">Deathknight's Reign</option>
                                        <Option value="items/swords/sword01.swf-">Default Sword</option>
                                        <Option value="items/swords/DefenderOfLight.swf-DefenderOfLight">Defender Of Light</option>
                                        <Option value="items/swords/DemonicDevourer.swf-DemonicDevourer">Demonic Devourer</option>
                                        <Option value="items/swords/SkyDstnydrgnblade.swf-">Destiny Dragon Blade</option>
                                        <Option value="items/maces/CrystalSkullMace.swf-CrystalSkullMace">Diamondmarrow Mace</option>
                                        <Option value="items/staves/Diamondsoftime.swf-Diamondsoftime">Diamonds Of Time</option>
                                        <Option value="items/swords/Limited02.swf-Limited02">Disaster</option>
                                        <Option value="items/staves/DiscordiaRose1.swf-DiscordiaRoseMiltonius1">Discordia Rose of Chaos v1</option>
                                        <Option value="items/staves/DiscordiaRose2.swf-DiscordiaRoseMiltonius2">Discordia Rose of Chaos</option>
                                        <Option value="items/polearms/DivineRetribution.swf-DivineRetribution">Divine Retribution</option>
                                        <Option value="items/swords/DjinnScimi.swf-DjinnScimi">Djinnitar</option>
                                        <Option value="items/axes/axe01.swf-">Double Bladed Axe</option>
                                        <Option value="items/swords/UnluckySword.swf-UnluckySword">Double Edged Unlucky Sword '09</option>
                                        <Option value="items/bows/DoubleRainBow.swf-DoubleRainBow">Double RainBow</option>
                                        <Option value="items/bows/DracoBow.swf-DracoBow">Dracolich Bow</option>
                                        <Option value="items/swords/sword26.swf-">Dragon Blade</option>
                                        <Option value="items/staves/CNYDFireStick.swf-CNYDFireStick">Dragon Dance Fire Stick</option>
                                        <Option value="items/swords/DragonsOverlordBlade.swf-DragonsOverlordBlade">Dragon Overlord Blade</option>
                                        <Option value="items/swords/sword04.swf-">Dragon Saw</option>
                                        <Option value="items/swords/Alteonchaosblade.swf-">Dragon Sword of Chaos</option>
                                        <Option value="items/guns/DragonToungeBow.swf-DragonToungeBow">Dragon Tongue Bow</option>
                                        <Option value="items/daggers/DragonToungeDagger.swf-DragonToungeDagger">Dragon Tongue Daggers</option>
                                        <Option value="items/polearms/DragonToungeScythe.swf-DragonToungeScythe">Dragon Tongue Scythe</option>
                                        <Option value="items/swords/DragonTounge.swf-DragonTounge">Dragon Tongue</option>
                                        <Option value="items/maces/Dragonwrench1.swf-">Dragon Wrench</option>
                                        <Option value="items/swords/WarriorMiltonPool2.swf-WarriorMiltonPool2">Dragonblade Of Miltonius</option>
                                        <Option value="items/bows/Dragonbow1.swf-Dragonbow1">Dragonbow</option>
                                        <Option value="items/guns/Dragongun1.swf-Dragongun1">Dragonburst</option>
                                        <Option value="items/staves/staff19.swf-">Dragonhead Archon</option>
                                        <Option value="items/swords/Dragonlordsword1.swf-">Dragonlord's Loss</option>
                                        <Option value="items/daggers/DragonSawBladeSet.swf-DragonSawBladeSet">Dragonsaw Blade Set</option>
                                        <Option value="items/daggers/RtRDaggerCC.swf-RtRDaggerCC">Dragonwings of Destiny CC</option>
                                        <Option value="items/daggers/DrowDagger01.swf-">Drake's Scimitar</option>
                                        <Option value="items/swords/sword51.swf-">Dread Iron</option>
                                        <Option value="items/swords/BoneMawSword.swf-BoneMawSword">Dreadcrystal Blade</option>
                                        <Option value="items/swords/ChaosDrowblade01.swf-">Drow Sabre</option>
                                        <Option value="items/daggers/DrumStyx.swf-DrumStyx">Drum Styx</option>
                                        <Option value="items/daggers/ControllerDaggers.swf-ControllerDaggers">Dual Controllers</option>
                                        <Option value="items/daggers/DualDragonSlayers.swf-DualDragonSlayers">Dual DragonSlayers</option>
                                        <Option value="items/swords/MiltonPoolswordManslayer2.swf-MiltonPoolswordManslayer2">Dual Green Manslayers</option>
                                        <Option value="items/swords/Terosinsword01.swf-Terosinsword01">Dual Terosin</option>
                                        <Option value="items/swords/VoidWeapon5.swf-VoidWeapon5">Dual Voidtebrae</option>
                                        <Option value="items/daggers/ScarabDagger.swf-ScarabDagger">Duat Daggers</option>
                                        <Option value="items/daggers/ClawDwarfhold.swf-">Dwarfhold Claws</option>
                                        <Option value="items/axes/dwarfaxe2.swf-">Dwarven Battle Axe</option>
                                        <Option value="items/guns/dwarfshotgun1.swf-">Dwarven Peppergun</option>
                                        <Option value="items/axes/dwarfaxe1.swf-">Dwarven Throwing Axe</option>
                                        <Option value="items/swords/CNYDSword.swf-CNYDSword">Dynasty's Destiny Blade</option>
                                        <Option value="items/staves/Surf2Zorbak2011.swf-SurfZorbak11">EBIL Surfboard</option>
                                        <Option value="items/swords/EcotoBlade.swf-EcotoBlade">EctoBlade</option>
                                        <Option value="items/maces/Grandeaster1.swf-">Eggstreme Egg Beater</option>
                                        <Option value="items/bows/ElegantOrnateLongBow.swf-ElegantOrnateLongBow">Elegant Ornate Long Bow</option>
                                        <Option value="items/polearms/EliteDragonSpear.swf-EliteDragonSpear">Elite Dragonspear</option>
                                        <Option value="items/staves/SimpleCloverStaff1.swf-SimpleCloverStaff1">Emerald Intricacy Staff</option>
                                        <Option value="items/daggers/BlackScorpionStinger.swf-BlackScorpionStinger">Emperor Scorpion Stingers</option>
                                        <Option value="items/polearms/MagicScythe.swf-MagicScythe">Empyrean Scythe</option>
                                        <Option value="items/swords/NewEnchantedSpirit.swf-NewEnchantedSpirit">Enchanted Spirit</option>
                                        <Option value="items/swords/sword30.swf-">End of Graves</option>
                                        <Option value="items/swords/WemasSwordEpic.swf-WemasSwordEpic">Epic Sword of Epicness</option>
                                        <Option value="items/swords/EvokerSoulBlade.swf-EvokerSoulBlade">Evoker of Souls</option>
                                        <Option value="items/swords/UBBLongSword.swf-UBBLongSword">Evolved Bunny Berserker Long Sword</option>
                                        <Option value="items/polearms/UBBSpear.swf-UBBSpear">Evolved Bunny Berserker Spear</option>
                                        <Option value="items/axes/axe10.swf-">Executioner Axe of Bludrut</option>
                                        <Option value="items/axes/ExecutionersJudgement.swf-ExecutionersJudgement">Executioner's Judgement</option>
                                        <Option value="items/daggers/KaraDagger.swf-KaraDagger">Faerie Sai</option>
                                        <Option value="items/guns/FalconeerBow.swf-FalconeerBow">Falconer's Bow</option>
                                        <Option value="items/swords/AutumnSword.swf-AutumnSword">Fallen Leaf Sword</option>
                                        <Option value="items/maces/FeatherDuster.swf-">Feather Duster</option>
                                        <Option value="items/swords/sword45.swf-">Fiendish Blood Blade</option>
                                        <Option value="items/polearms/belrotpole01.swf-">Fiendish Impaler</option>
                                        <Option value="items/swords/sword33.swf-">Fiery Blade of Torment</option>
                                        <Option value="items/swords/FlamedAuraBlade.swf-FlamedAuraBlade">Flamed Aura Blade</option>
                                        <Option value="items/staves/MiltonPoolstaff02.swf-">Focus Staff Of Miltonius</option>
                                        <Option value="items/swords/mogloween2010.swf-mogloween2010">For The Gourd</option>
                                        <Option value="items/swords/FortuneBringer.swf-FortuneBringer">Fortune Bringer</option>
                                        <Option value="items/swords/FortunesProtector.swf-FortunesProtector">Fortune's Protector</option>
                                        <Option value="items/swords/FrogCookie1.swf-FrogCookie1">Frog Cookie Beta Version</option>
                                        <Option value="items/swords/FrogCookie2.swf-FrogCookie1">Frog Cookie</option>
                                        <Option value="items/swords/Frostwyrmsword02.swf-Frostwyrmsword02">Frost Matriarch Sword</option>
                                        <Option value="items/swords/FrostBite.swf-FrostBite">Frostbite</option>
                                        <Option value="items/swords/Frostbyte.swf-Frostbyte">Frostbyte</option>
                                        <Option value="items/swords/Frozensword1.swf-Frozensword1">Frosted Falchion</option>
                                        <Option value="items/swords/Frostworn.swf-">FrostReaver</option>
                                        <Option value="items/daggers/FrostDualsword01.swf-FrostDualsword01">FrostScythe Dual Blades</option>
                                        <Option value="items/daggers/FrostSwordnBoard01.swf-FrostSwordnBoard01">FrostScythe's Battlegear</option>
                                        <Option value="items/polearms/Frostscythe1.swf-">FrostScythe's Cruelty</option>
                                        <Option value="items/swords/SkyFrostusRectar.swf-">Frostus Rectar</option>
                                        <Option value="items/daggers/MMS.swf-MMS">Frostval Sword and Shield</option>
                                        <Option value="items/maces/FryingPan.swf-">Frying Pan</option>
                                        <Option value="items/swords/Furai.swf-Furai">Furai</option>
                                        <Option value="items/polearms/Naginata1.swf-">Furious Naginata</option>
                                        <Option value="items/swords/furyblade.swf-furyblade">Furore's Fury Blade</option>
                                        <Option value="items/staves/AstralGalaxyScythe.swf-AstralGalaxyScythe">Galaxscythe</option>
                                        <Option value="items/axes/gargoyleAxe.swf-">Gargoyle Axe</option>
                                        <Option value="items/swords/sword01a.swf-">Genesis Sword</option>
                                        <Option value="items/swords/sword38.swf-">Ghost's blade of spooky hotness (Ghost)</option>
                                        <Option value="items/staves/ghostStaff.swf-">Ghostly Staff</option>
                                        <Option value="items/maces/mace11.swf-">Giant Lolipop</option>
                                        <Option value="items/daggers/TempleDaggers.swf-TempleDaggers">Gilded Sek Duat Daggers</option>
                                        <Option value="items/maces/KaliMace1.swf-KaliMace1">Gilt Mace of Kalestri</option>
                                        <Option value="items/swords/GingerBreadBlade.swf-GingerBreadBlade">Gingerbread Blade</option>
                                        <Option value="items/swords/GlacierKnuckleSword.swf-GlacierKnuckleSword">Glacial Knuckle Sword</option>
                                        <Option value="items/swords/DarkCrownSword.swf-DarkCrownSword">Glowing Crown Blade</option>
                                        <Option value="items/swords/AstralManaCleaver.swf-AstralManaCleaver">Gnostic Cleaver</option>
                                        <Option value="items/axes/WheelMiltonPoolDragonAxe.swf-WheelMiltonPoolDragonAxe">Godly Golden Dragon Axe</option>
                                        <Option value="items/maces/Grand03.swf-">Godly Mace of the Ancients</option>
                                        <Option value="items/axes/Kaliaxe01.swf-Kaliaxe01">Golden Axe of Kalestri</option>
                                        <Option value="items/swords/GoodVampireBlade.swf-GoodVampireBlade">Golden Blade of Sanctity</option>
                                        <Option value="items/polearms/ShamrockAxeblade.swf-ShamrockAxeblade">Golden Clover Cleaver</option>
                                        <Option value="items/maces/CobraMace.swf-CobraMace">Golden Cobra Mace</option>
                                        <Option value="items/swords/GoldenCrusherBlade.swf-GoldenCrusherBlade">Golden Crusher Blade</option>
                                        <Option value="items/swords/GoldenDeathSaw.swf-GoldenDeathSaw">Golden DeathSaw</option>
                                        <Option value="items/swords/GoldenDestiny.swf-GoldenDestiny">Golden Destiny</option>
                                        <Option value="items/swords/dracsword1.swf-">Golden Draconian Sword</option>
                                        <Option value="items/swords/GoldenDragonblade.swf-GoldenDragonblade">Golden Dragonblade</option>
                                        <Option value="items/guns/GoldenFlintlock.swf-">Golden Flintlock Pistol</option>
                                        <Option value="items/swords/GoldenHarvestScythe.swf-GoldenHarvestScythe">Golden Harvest Scythe</option>
                                        <Option value="items/maces/GoldenMace.swf-GoldenMace">Golden Mace</option>
                                        <Option value="items/swords/GoldenPhoenixBlade1.swf-">Golden Phoenix Sword</option>
                                        <Option value="items/staves/GoldenShamrockStaff1.swf-GoldenShamrockStaff1">Golden Shamrock Staff</option>
                                        <Option value="items/staves/ShadowStaffGoodVersion.swf-ShadowStaffGoodVersion">Golden Staff of Virtue</option>
                                        <Option value="items/staves/GoldenStaff.swf-GoldenStaff">Golden Staff</option>
                                        <Option value="items/swords/starswordgold.swf-">Golden Star Sword</option>
                                        <Option value="items/daggers/Goldrecord.swf-Goldrecord">Golden Wreckord</option>
                                        <Option value="items/maces/enchantedsphere.swf-">Grand Inquisitor's Mace</option>
                                        <Option value="items/daggers/Voiddagger02.swf-Voiddagger02">Grasp of the Void</option>
                                        <Option value="items/maces/mugCoffee.swf-mugCoffee">Gravity Defying Coffee Mug</option>
                                        <Option value="items/swords/GreatFireBlade.swf-GreatFireBlade">Great Fire Blade</option>
                                        <Option value="items/swords/sword55.swf-">Great Pumpkin King Sword</option>
                                        <Option value="items/staves/VoidWeapon4.swf-VoidWeapon4">Great Void Vertebrae</option>
                                        <Option value="items/swords/CreeperMiltoniussword02.swf-CreeperMiltoniussword02">Greater Creep Blade</option>
                                        <Option value="items/staves/Glowstick4.swf-">Green GlowStick</option>
                                        <Option value="items/maces/StarGuitarGreen.swf-StarGuitarGreen">Green StarGuitar</option>
                                        <Option value="items/swords/Gressilsword01.swf-Gressilsword01">Gressil's Impurity</option>
                                        <Option value="items/axes/UndeadGrimAxe.swf-UndeadGrimAxe">Grim Bone Chopper</option>
                                        <Option value="items/swords/GrimElegance.swf-GrimElegance">Grim Elegance</option>
                                        <Option value="items/swords/GrimShortBlades.swf-GrimShortBlades">Grim Short Blades</option>
                                        <Option value="items/polearms/Shadowpolearm02.swf-">Grim's Shadow Scythe</option>
                                        <Option value="items/maces/Grumpywarhammer1.swf-">Grumpy Warhammer</option>
                                        <Option value="items/swords/dwarfsword2.swf-">Grund Dwarven Broadsword</option>
                                        <Option value="items/swords/dwarfsword3.swf-">Grundmir Master Dwarven Broadsword</option>
                                        <Option value="items/polearms/polearm10.swf-Guandao">Guandao of Slaying</option>
                                        <Option value="items/swords/sword24.swf-">Guardian Blade</option>
                                        <Option value="items/swords/GuardianofVirtue.swf-GuardianofVirtue">Guardian Of Virtue</option>
                                        <Option value="items/swords/Chainsaw6.swf-">Guardian's Chainsaw</option>
                                        <Option value="items/maces/mugNythera.swf-mugNythera">Half-Dragon Berry Mug</option>
                                        <Option value="items/polearms/NytherasCross.swf-NytherasCross">Half-Dragon's Havoc</option>
                                        <Option value="items/daggers/HandColt.swf-HandColt">Hand Of the Hoof</option>
                                        <Option value="items/swords/Hanzamunesword02.swf-Hanzamunesword02">Hanzamune Sheathed</option>
                                        <Option value="items/swords/Hanzamunesword01.swf-Hanzamunesword01">Hanzamune</option>
                                        <Option value="items/staves/staff03.swf-">Harnessed Cat's Eye</option>
                                        <Option value="items/swords/HarvestScythe.swf-HarvestScythe">Harvest Scythe</option>
                                        <Option value="items/daggers/PlentySwordShield2.swf-PlentySwordShield2">Harvest Sword and Shield</option>
                                        <Option value="items/daggers/Hawkarang.swf-Hawkarang">Hawkarang</option>
                                        <Option value="items/swords/HayatosWrath.swf-HayatosWrath">Hayato's Wrath</option>
                                        <Option value="items/maces/HeartBreaker.swf-HeartBreaker">Heart Breaker</option>
                                        <Option value="items/swords/Valen01.swf-">Heart Sabre</option>
                                        <Option value="items/axes/Patrickaxe01.swf-Patrickaxe01">Heavy Celtic Axe</option>
                                        <Option value="items/swords/HeroHeroSlasher.swf-HeroHeroSlasher">Hero Heart Slasher</option>
                                        <Option value="items/swords/MiltonPoolHex01.swf-MiltonPoolHex01">Hex blade of Miltonius</option>
                                        <Option value="items/staves/HighAzureStaff.swf-HighAzureStaff">High Azure Staff</option>
                                        <Option value="items/axes/FrostHatchet.swf-FrostHatchet">Hoarfrost Hatchet</option>
                                        <Option value="items/polearms/HockeyStick.swf-">Hockey Stick</option>
                                        <Option value="items/swords/Holiblade.swf-Holiblade">Holiblade</option>
                                        <Option value="items/polearms/HolloEnergy.swf-HolloEnergy">HolloEnergy Blade</option>
                                        <Option value="items/swords/HollowSoulBlade.swf-HollowSoulBlade">Hollow Soul Blade</option>
                                        <Option value="items/daggers/HollowSoulDagger.swf-HollowSoulDagger">Hollow Soul Dagger</option>
                                        <Option value="items/staves/HollowSoulStaff.swf-HollowSoulStaff">Hollow Soul Staff</option>
                                        <Option value="items/swords/HollowsoulLance.swf-HollowsoulLance">Hollowsoul Lance</option>
                                        <Option value="items/daggers/HollowShieldSword.swf-HollowShieldSword">HollowSword and Shield</option>
                                        <Option value="items/polearms/HollyTrident.swf-HollyTrident">Holly Trident</option>
                                        <Option value="items/maces/Grand01.swf-">Holy Hammer of Retribution</option>
                                        <Option value="items/daggers/HolyHandGrenade.swf-HolyHandGrenade">Holy Hand Grenade</option>
                                        <Option value="items/swords/HopeBringerBlade.swf-HopeBringerBlade">HopeBringer Blade</option>
                                        <Option value="items/staves/staff01.swf-">Horatio's Staff</option>
                                        <Option value="items/polearms/HorcPolearm1.swf-">Horc Hacker</option>
                                        <Option value="items/swords/HorcSellswordScimitar.swf-HorcSellswordScimitar">Horc Sell-sword Scimitar</option>
                                        <Option value="items/daggers/SnowFlakeSet.swf-SnowFlakeSet">Howling Frost Set</option>
                                        <Option value="items/daggers/newbiedagger02.swf-">Hunter's Dagger</option>
                                        <Option value="items/swords/sword11.swf-">Hydra Blade</option>
                                        <Option value="items/staves/staff08.swf-">Hydra Staff</option>
                                        <Option value="items/swords/IchidoriPersonal.swf-IchidoriPersonal">Ichidori's Personal Sword</option>
                                        <Option value="items/axes/Kama1.swf-">Imperial Kama</option>
                                        <Option value="items/polearms/Naginata2.swf-">Imperial Naginata</option>
                                        <Option value="items/swords/IncandesFulminatus.swf-IncandesFulminatus">Incandes Fulminatus</option>
                                        <Option value="items/swords/InfernalRocks.swf-InfernalRocks">Infernal Rocks</option>
                                        <Option value="items/guns/irolustre.swf-">Irolustre's Steam Gun/Sword</option>
                                        <Option value="items/axes/Canadianaxe01.swf-">Iron Maple Leaf Axe</option>
                                        <Option value="items/daggers/MiltonPoolSecretdagger01.swf-MiltonPoolSecretdagger01">Iron Scythe of Miltoius</option>
                                        <Option value="items/polearms/Chaospolearm01.swf-">Iron Spear of Chaos</option>
                                        <Option value="items/polearms/polearm05.swf-">Iron Spear</option>
                                        <Option value="items/swords/sword42.swf-">Iryerris</option>
                                        <Option value="items/swords/sword44.swf-">Ivy Blade</option>
                                        <Option value="items/daggers/J6Firearms.swf-J6Firearms">J6's Birthday Guns</option>
                                        <Option value="items/swords/Lightsaber.swf-Lightsaber">J6's Lightsaber</option>
                                        <Option value="items/swords/J6Machete.swf-J6Machete">J6's Machete</option>
                                        <Option value="items/maces/J6Map_r1.swf-J6Map">J6's Secret Hideout Map</option>
                                        <Option value="items/guns/shotgunj6.swf-shotgunj6">J6's Shotgun</option>
                                        <Option value="items/swords/WolfWarriorBlade02.swf-WolfWarriorBlade02">Jagged Wolf Blade</option>
                                        <Option value="items/maces/jesterclub.swf-jesterclub">Jester's Folly</option>
                                        <Option value="items/polearms/JudgementScythe.swf-JudgementScythe">Judgement Scythe</option>
                                        <Option value="items/swords/JusticeBlade.swf-JusticeBlade">Justice Blade</option>
                                        <Option value="items/swords/SkyKage.swf-">Kage</option>
                                        <Option value="items/swords/Kalisword01.swf-Kalisword01">Kalestri Cutlass</option>
                                        <Option value="items/polearms/Kalipolearm01.swf-Kalipolearm01">Kalestri Polearm</option>
                                        <Option value="items/daggers/KaraDagger.swf-KaraDagger">Kara's Dagger</option>
                                        <Option value="items/axes/dwarfaxe3.swf-">Karag Battleaxe</option>
                                        <Option value="items/swords/swordNinjaTrainer.swf-">Katana of Cold</option>
                                        <Option value="items/swords/sword08.swf-">Katana</option>
                                        <Option value="items/swords/KeeperOfDarkness.swf-KeeperOfDarkness">Keeper Of Darkness</option>
                                        <Option value="items/staves/LuckySerpentHealerStaff1.swf-LuckySerpentHealerStaff1">Kelly's Charm Staff</option>
                                        <Option value="items/swords/sword18.swf-">King's Blade</option>
                                        <Option value="items/swords/CelticSword1.swf-CelticSword1">Kismet's Edge</option>
                                        <Option value="items/maces/KitchenSink.swf-">Kitchen Sink</option>
                                        <Option value="items/swords/koisword.swf-koisword">Koi's Sword</option>
                                        <Option value="items/swords/korinsword.swf-korinsword">Korin's Sword (Big)</option>
                                        <Option value="items/swords/korinsword.swf-">Korin's Sword (Small)</option>
                                        <Option value="items/axes/axe09.swf-">Krom's Conquest</option>
                                        <Option value="items/swords/ladyablade.swf-ladyablade">Lady Adellandra's Sword - BETA</option>
                                        <Option value="items/swords/ladyablade2.swf-ladyablade2">Lady Adellandra's Sword</option>
                                        <Option value="items/guns/Raygun1.swf-Raygun1">Laser Beam</option>
                                        <Option value="items/guns/LaserWhip.swf-LaserWhip">Laser Whip</option>
                                        <Option value="items/polearms/KalhiSpear.swf-KalhiSpear">Legacy Spear</option>
                                        <Option value="items/swords/Fireblade1.swf-">Legendary Magma Sword</option>
                                        <Option value="items/axes/LichBane.swf-LichBane">Lich Bane</option>
                                        <Option value="items/axes/LODD.swf-LODD">Light of Digital Destiny</option>
                                        <Option value="items/daggers/LiveDagger1.swf-LiveDagger1">Live Dragon Daggers</option>
                                        <Option value="items/swords/LlussionSword.swf-">Llussion Sword</option>
                                        <Option value="items/daggers/LycanDagger1.swf-LycanDagger1">Long Lycan Dagger</option>
                                        <Option value="items/swords/Longclaw.swf-Longclaw">Longclaw</option>
                                        <Option value="items/daggers/SandseaClaws.swf-SandseaClaws">Lost Claws of the Oasis</option>
                                        <Option value="items/swords/MerFolkJaggedBlade.swf-MerFolkJaggedBlade">Lotic Blade</option>
                                        <Option value="items/daggers/Fan01.swf-">Lovely Fan</option>
                                        <Option value="items/swords/polistarsword1.swf-polistarsword1">Lucky Coin Katana</option>
                                        <Option value="items/maces/LuckyHammer.swf-LuckyHammer">Lucky Hammer</option>
                                        <Option value="items/swords/ShamrockSword.swf-">Lucky Sword</option>
                                        <Option value="items/axes/axe12.swf-">Lumberjack Axe</option>
                                        <Option value="items/daggers/CelSandClaw1.swf-CelSandClaw1">Lumina Claw</option>
                                        <Option value="items/swords/CNYDKatana.swf-CNYDKatana">Lunisolar Katana</option>
                                        <Option value="items/swords/VoidWeapon1.swf-VoidWeapon1">Lurid Blade of the Void</option>
                                        <Option value="items/maces/ShadowMace02.swf-">Mace of the Fiend</option>
                                        <Option value="items/swords/CelticSword2.swf-CelticSword2">Malachite Cutter</option>
                                        <Option value="items/polearms/MalaniPolearm.swf-MalaniPolearm">Malani Polearm</option>
                                        <Option value="items/daggers/AKscimi.swf-AKscimi">Malani Scimitar</option>
                                        <Option value="items/staves/ManaCircleStaff.swf-ManaCircleStaff">Mana Circle Staff</option>
                                        <Option value="items/swords/belrot2.swf-">Mana Crusher</option>
                                        <Option value="items/maces/belrotmace01.swf-">Mana Mace</option>
                                        <Option value="items/staves/ManaScepter.swf-ManaScepter">Mana Scepter</option>
                                        <Option value="items/staves/ManaTridentStaff.swf-ManaTridentStaff">Mana Trident</option>
                                        <Option value="items/swords/CreatureBlade.swf-CreatureBlade">Many-Eyed Monstrosity</option>
                                        <Option value="items/swords/syrupbottle.swf-syrupbottle">Maple Syrup Bottle</option>
                                        <Option value="items/swords/HorcSword1.swf-">Massive Horc Cleaver</option>
                                        <Option value="items/axes/MassiveBloodAxe.swf-MassiveBloodAxe">Massive Rock Axe</option>
                                        <Option value="items/axes/cleaver01.swf-Cleaver01">Meat Cleaver</option>
                                        <Option value="items/maces/SausageSword.swf-">Meat on a Stick</option>
                                        <Option value="items/guns/MegaphoneGun.swf-MegaphoneGun">Megaphone MegaGun</option>
                                        <Option value="items/swords/SantaSword1.swf-SantaSword1">Merrymaker</option>
                                        <Option value="items/staves/CrescentStaff02.swf-CrescentStaff02">Metallic Crescent Staff</option>
                                        <Option value="items/daggers/daggerRogueTrainer.swf-">Metrea's Disciple</option>
                                        <Option value="items/daggers/BatDagger02.swf-">Misericorde de Nyx</option>
                                        <Option value="items/swords/BladeofDiscordMog.swf-BladeofDiscordMog">Mogloween Discord</option>
                                        <Option value="items/polearms/Playerspear1.swf-Playerspear1">Morose Spear</option>
                                        <Option value="items/maces/motherbouquet.swf-motherbouquet">Mother's Day Bouquet</option>
                                        <Option value="items/polearms/MummyWepDrop.swf-MummyWepDrop">Moumiya Scythe</option>
                                        <Option value="items/axes/SwampMonsterAxe.swf-SwampMonsterAxe">Mudluk Monster Axe</option>
                                        <Option value="items/swords/MysticBleu.swf-MysticBleu">Mystic Bleu</option>
                                        <Option value="items/axes/Tribalaxe01.swf-">Mystic Tribal Axe</option>
                                        <Option value="items/daggers/Tribaldagger01.swf-">Mystic Tribal Dagger</option>
                                        <Option value="items/swords/Tribalsword01.swf-Tribalsword01">Mystic Tribal Sword</option>
                                        <Option value="items/swords/MythicalBlackIron.swf-MythicalBlackIron">Mythical Black Iron</option>
                                        <Option value="items/swords/Seppysword1.swf-">Necrotic Blade of Chaos</option>
                                        <Option value="items/swords/persosword.swf-persosword">NEED NAME - Pero Sword</option>
                                        <Option value="items/guns/NegativePlazmatron.swf-NegativePlazmatron">Negative Plazmatron</option>
                                        <Option value="items/swords/Nekosword1.swf-">Nekoyasha Blade</option>
                                        <Option value="items/axes/NightmareAxe.swf-NightmareAxe">Nightmare Axe</option>
                                        <Option value="items/swords/Nightmaresword1.swf-">Nightmare Blade</option>
                                        <Option value="items/maces/Nightmaremace1.swf-">Nightmare Mace</option>
                                        <Option value="items/axes/NightShockAxe.swf-NightShockAxe">Nightshock Axe</option>
                                        <Option value="items/swords/NightShockSword.swf-NightShockSword">Nightshock Sword</option>
                                        <Option value="items/swords/sword02.swf-">Ninja Sword</option>
                                        <Option value="items/swords/sword02.swf-">Ninja Sword</option>
                                        <Option value="items/swords/Noblesword1.swf-Noblesword1">Noble Blade</option>
                                        <Option value="items/daggers/NOTrutoChakram01.swf-">NOTruto Chakram</option>
                                        <Option value="items/staves/NovelCrystalRunedStaff.swf-NovelCrystalRunedStaff">Novel Crystal Runed Staff</option>
                                        <Option value="items/swords/MarshmallowNuke.swf-MarshmallowNuke">Nuked Mallow</option>
                                        <Option value="items/maces/cyseroflowers.swf-cyseroflowers">Nursey's Wedding Bouquet</option>
                                        <Option value="items/polearms/NytherasScythe.swf-NytherasScythe">Nythera's Ultimate Scythe Bigger</option>
                                        <Option value="items/polearms/NytherasScythe2.swf-NytherasScythe2">Nythera's Ultimate Scythe</option>
                                        <Option value="items/swords/NytheraWeddingGlave.swf-NytheraWeddingGlave">Nythera's Wedding Glave</option>
                                        <Option value="items/daggers/ODK1.swf-ODK1">Obsidian Katanas</option>
                                        <Option value="items/polearms/polearm07.swf-">Odanata Weapon</option>
                                        <Option value="items/polearms/OldMoon.swf-OldMoon">Old Moon</option>
                                        <Option value="items/bows/OED6.swf-OED6">One Eyed Bow</option>
                                        <Option value="items/capes/OneEyeDollCape.swf-OneEyeDollCape">One Eyed Crawler Cape</option>
                                        <Option value="items/swords/DoomHelionLance.swf-DoomHelionLance">One Eyed DoomLance</option>
                                        <Option value="items/swords/OneEyedRuneBlade.swf-OneEyedRuneBlade">One Eyed Rune Blade</option>
                                        <Option value="items/axes/GrimOEDAxe.swf-GrimOEDAxe">One-Eyed Axe of Agony</option>
                                        <Option value="items/swords/OEDClawBlade.swf-OEDClawBlade">One-Eyed Warrior Blade</option>
                                        <Option value="items/swords/Starswordblack.swf-Starswordblack">Onyx Starsword</option>
                                        <Option value="items/swords/OrnateMoglinClaymore.swf-OrnateMoglinClaymore">Ornate Moglin Claymore</option>
                                        <Option value="items/daggers/OrnatePlatinumImpalers.swf-OrnatePlatinumImpalers">Ornate Platinum Impalers</option>
                                        <Option value="items/swords/OrnateVampireSlayer.swf-OrnateVampireSlayer">Ornate Vampire Slayer</option>
                                        <Option value="items/swords/MiltoniusNulgathsword01.swf-MiltoniusNulgathsword01">Overfiend Blade of Nulgath</option>
                                        <Option value="items/swords/PainSawGhost.swf-PainSawGhost">PainSaw of Eidolon</option>
                                        <Option value="items/swords/sword37.swf-">Pandora</option>
                                        <Option value="items/swords/BirthdaySword01.swf-BirthdaySword01">Party Slasher Birthday Sword</option>
                                        <Option value="items/maces/lollypop2.swf-PeppermintLollipop">Peppermint Lollipop</option>
                                        <Option value="items/polearms/PetrifiedAutumnWood.swf-PetrifiedAutumnWood">Petrified Autumn Wood</option>
                                        <Option value="items/swords/SandseaSlasher2.swf-SandseaSlasher2">Pharaoh's Bane</option>
                                        <Option value="items/swords/CobraBladeSand.swf-CobraBladeSand">Pharaoh's Wedjat</option>
                                        <Option value="items/swords/MiltonPoolPhoenixSword02.swf-MiltonPoolPhoenixSword02">Phoenix Blade of Miltonius</option>
                                        <Option value="items/swords/sword40.swf-">Phoenix Blade</option>
                                        <Option value="items/swords/HeartReaperPink.swf-HeartReaperPink">Pink Heart Reaper</option>
                                        <Option value="items/maces/hedgehogpink.swf-hedgehogpink">Pink Hedgehog Plushie of Doom</option>
                                        <Option value="items/guns/PirateFlintlock.swf-PirateFlintlock">Pirate Flintlock Pistol</option>
                                        <Option value="items/axes/axe11.swf-">Piston-Driven Chopper</option>
                                        <Option value="items/polearms/Dwakelmechpolearm1.swf-Dwakelmechpolearm1">Piston-Driven Polearm</option>
                                        <Option value="items/swords/PlasmaShard.swf-PlasmaShard">Plasma Shard</option>
                                        <Option value="items/axes/axePlatinum.swf-">Platinum Axe Of Destiny</option>
                                        <Option value="items/axes/Platinumrecord.swf-Platinumrecord">Platinum Axe of Rechord</option>
                                        <Option value="items/axes/PlatinumBroadAxe.swf-PlatinumBroadAxe">Platinum Broad Axe</option>
                                        <Option value="items/swords/PlatinumBroadSword.swf-PlatinumBroadSword">Platinum Broad Sword</option>
                                        <Option value="items/maces/PlatinumMace.swf-PlatinumMace">Platinum Mace</option>
                                        <Option value="items/swords/PTRSword2.swf-PTRSword2">Plundered Tarnished Rapier</option>
                                        <Option value="items/maces/plungermace.swf-plungermace">Port-A-Plunger Mace</option>
                                        <Option value="items/maces/PortableOrchestra.swf-PortableOrchestra">Portable Orchestra</option>
                                        <Option value="items/guns/PotionGun.swf-PotionGun">Potion Gun</option>
                                        <Option value="items/staves/PotionStaff.swf-PotionStaff">Potion Staff</option>
                                        <Option value="items/staves/PotionWand.swf-PotionWand">Potion Wand</option>
                                        <Option value="items/bows/PTRBow.swf-PTRBow">Precise Talisman of the Ranger </option>
                                        <Option value="items/swords/PTRSword.swf-PTRSword">Precision Tachi of the Remarkable</option>
                                        <Option value="items/swords/MiltonPoolsword03.swf-MiltonPoolsword03">Primal Dread Saw of Miltonius Weapon</option>
                                        <Option value="items/swords/VoidWeapon2.swf-VoidWeapon2">Primordial Edge</option>
                                        <Option value="items/daggers/LycanDagger3.swf-LycanDagger3">Prismatic Long Lycan dagger</option>
                                        <Option value="items/axes/PTRAxe2.swf-PTRAxe2">Prized Tomahawk of the Revered</option>
                                        <Option value="items/staves/GoldenStaff2.swf-GoldenStaff2">Pulsing Golden Staff</option>
                                        <Option value="items/axes/Pumpkinaxe01.swf-">Pumpkin Axe</option>
                                        <Option value="items/swords/Pumpkinsword01.swf-">Pumpkin Sword</option>
                                        <Option value="items/daggers/BrazillianDagger.swf-BrazillianDagger">Punhais Brasileiros</option>
                                        <Option value="items/daggers/MiltonPoolClaw02.swf-MiltonPoolClaw02">Purified Claw of Miltonius</option>
                                        <Option value="items/maces/SpikedBoneClub.swf-SpikedBoneClub">Putrid Meaty Club</option>
                                        <Option value="items/guns/RabbitCannon.swf-RabbitCannon">Rabbit Cannon</option>
                                        <Option value="items/swords/LedgeSword.swf-LedgeSword">Radiant Ledgesword</option>
                                        <Option value="items/swords/Ragestar.swf-Ragestar">Ragestar</option>
                                        <Option value="items/swords/sword50.swf-">Random Weapon of Miltonius</option>
                                        <Option value="items/swords/MiltonPoolsword02.swf-MiltonPoolsword02">Random Weapon of Miltonius[Daggers]</option>
                                        <Option value="items/swords/sword34.swf-">Randor the Red's Beta Sword</option>
                                        <Option value="items/swords/RandorRedSword.swf-RandorRedSword">Randor the Red's Sword</option>
                                        <Option value="items/swords/rapier1.swf-">Rapier</option>
                                        <Option value="items/swords/AstralManaBlade.swf-AstralManaBlade">Raw Mana Blade</option>
                                        <Option value="items/daggers/ZealithReaverSand.swf-ZealithReaverSand">Reavers of Amenti</option>
                                        <Option value="items/axes/dblAxeBladeRed.swf-">Red Double Axe Blade </option>
                                        <Option value="items/staves/Glowstick1.swf-">Red GlowStick</option>
                                        <Option value="items/swords/HeartReaperRed.swf-HeartReaperRed">Red Heart Reaper</option>
                                        <Option value="items/polearms/pitchforkred.swf-">Red Pitchfork</option>
                                        <Option value="items/maces/StarGuitar.swf-StarGuitar">Red StarGuitar</option>
                                        <Option value="items/swords/Starsword1.swf-">Red Starsword</option>
                                        <Option value="items/swords/CrystalSwiftBlade.swf-CrystalSwiftBlade">Refined Crystal Sword</option>
                                        <Option value="items/swords/sword09.swf-">ReignBringer</option>
                                        <Option value="items/swords/RenownedArcaneClaymore.swf-RenownedArcaneClaymore">Renowned Arcane Claymore</option>
                                        <Option value="items/swords/RetributionofTheFallen.swf-RetributionofTheFallen">Retribution of the Fallen</option>
                                        <Option value="items/swords/MarshmallowFire.swf-MarshmallowFire">Roasted Marshmallow</option>
                                        <Option value="items/swords/DjinnRock.swf-DjinnRock">Rock of the Djinn</option>
                                        <Option value="items/swords/DjinnRock.swf-DjinnRock">Rock of the Djinn</option>
                                        <Option value="items/maces/Rolly16Bit.swf-Rolly16Bit">Rolith's Digital Hammer</option>
                                        <Option value="items/maces/mace06.swf-">Rolith's Mace</option>
                                        <Option value="items/swords/Rosesword1.swf-">Rose Thorn Blade</option>
                                        <Option value="items/swords/Roseblood.swf-Roseblood">Roseblood</option>
                                        <Option value="items/swords/sword05a.swf-">Royal Blade of Thorns</option>
                                        <Option value="items/swords/Runesword01.swf-">Rune Sword</option>
                                        <Option value="items/swords/SkyguardRuneblade.swf-SkyguardRuneblade">Runed Skyguard Sword</option>
                                        <Option value="items/swords/newbiesword1.swf-">Rusted Sword</option>
                                        <Option value="items/maces/pipe1.swf-">Rusty Pipe</option>
                                        <Option value="items/maces/Soulnuke.swf-">Ryoku's Soul Nuke</option>
                                        <Option value="items/swords/Safiriasword01.swf-Safiriasword01">Safiria's Temper</option>
                                        <Option value="items/swords/SamuraiSword01.swf-">Samurai Katana</option>
                                        <Option value="items/polearms/SandseaScythe1.swf-SandseaScythe1">Sand Spear Sickle</option>
                                        <Option value="items/bows/SandRunnerLongbow.swf-SandRunnerLongbow">Sandrunner Longbow</option>
                                        <Option value="items/daggers/SandSeascimitar.swf-SandSeascimitar">SandSea Scimitars</option>
                                        <Option value="items/daggers/SerpentClaws.swf-SerpentClaws">Sandsea Serpent Clawsss</option>
                                        <Option value="items/daggers/KaliDagger01.swf-KaliDagger01">Sandsea Sickles</option>
                                        <Option value="items/daggers/SandseaSlasher1.swf-SandseaSlasher1">Sandsea Slasher</option>
                                        <Option value="items/swords/WaveCutter.swf-WaveCutter">Sandsea WaveCutter</option>
                                        <Option value="items/daggers/Claw02.swf-Claw02">Santa's Impaler</option>
                                        <Option value="items/maces/SausageChucks.swf-SausageChucks">Sausage Chucks</option>
                                        <Option value="items/swords/ScakkSlayer.swf-">Scakk Slayer</option>
                                        <Option value="items/axes/ScarabMace.swf-ScarabMace">Scarab Mace</option>
                                        <Option value="items/swords/ScarabSlicer.swf-ScarabSlicer">Scarab Slicer</option>
                                        <Option value="items/staves/Grandstaff01.swf-">Scepter of the Divine</option>
                                        <Option value="items/swords/MerFolkMakoBlade.swf-MerFolkMakoBlade">Scimitar Of The Seventh Sea</option>
                                        <Option value="items/swords/sword14.swf-">Scimitar</option>
                                        <Option value="items/daggers/scissors1.swf-">Scissors</option>
                                        <Option value="items/daggers/Claw05.swf-">Scorpion Claw</option>
                                        <Option value="items/polearms/GhostlyScythe.swf-GhostlyScythe">Scythe of Revenant</option>
                                        <Option value="items/polearms/ScytheoftheOldKings.swf-ScytheoftheOldKings">Scythe of the Old Kings</option>
                                        <Option value="items/swords/sword13.swf-">Sepulchure's Undead Blade</option>
                                        <Option value="items/swords/SerpentShortSword.swf-SerpentShortSword">Serpent Shortswords</option>
                                        <Option value="items/swords/Chaossword02.swf-Chaossword02">Serrated Chaos Edge</option>
                                        <Option value="items/swords/Pilgrimsword01.swf-Pilgrimsword01">Settler's Double Sword</option>
                                        <Option value="items/swords/Pilgrimsword03.swf-Pilgrimsword03">Settler's Greatsword</option>
                                        <Option value="items/swords/Pilgrimsword02.swf-Pilgrimsword02">Settler's Longsword</option>
                                        <Option value="items/guns/SG3000.swf-SG3000">SG3000</option>
                                        <Option value="items/swords/shadocon.swf-shadocon">Shadocon Sword</option>
                                        <Option value="items/swords/Shadowsword01.swf-">Shadow Ninja Blade</option>
                                        <Option value="items/polearms/polearm09.swf-">Shadow Serpent Scythe</option>
                                        <Option value="items/polearms/MiltonPoolpolearm01.swf-MiltonPoolpolearm01">Shadow Spear of Miltonius</option>
                                        <Option value="items/swords/Vsword02.swf-Vsword02">Shadow Z Sword</option>
                                        <Option value="items/axes/ShadowReaperOfDoom.swf-ShadowReaperOfDoom">ShadowReaper Of Doom</option>
                                        <Option value="items/swords/GoodSwordEvil.swf-GoodSwordEvil">Shadowscythe Avastilator</option>
                                        <Option value="items/swords/Chainsaw5.swf-">Shadowscythe Chainsaw</option>
                                        <Option value="items/maces/ShadowscytheReaperGuitar.swf-ShadowscytheReaperGuitar">Shadowscythe Reaper Guitar</option>
                                        <Option value="items/polearms/LeppyScythe.swf-LeppyScythe">Shamrockin' Scythe</option>
                                        <Option value="items/guns/CrystalGun.swf-CrystalGun">Shifting Crystal Pistol</option>
                                        <Option value="items/swords/SilverRipper.swf-SilverRipper">Silver Ripper</option>
                                        <Option value="items/daggers/SilverThrowingKnife.swf-SilverThrowingKnife">Silver Throwing Knife</option>
                                        <Option value="items/daggers/CelticDagger.swf-CelticDagger">Simple Celtic Dagger</option>
                                        <Option value="items/polearms/Pole_Temp.swf-">Simple Poleaxe</option>
                                        <Option value="items/swords/MiltonPoolWheelsword02.swf-MiltonPoolWheelsword02">Sinister Leech Blade of Miltonius</option>
                                        <Option value="items/daggers/SinisterPumpkinSickle.swf-SinisterPumpkinSickle">Sinister Pumpkin Sickles</option>
                                        <Option value="items/swords/SinisterPumpkinKingBlade.swf-SinisterPumpkinKingBlade">Sinister PumpkinKing Blade</option>
                                        <Option value="items/staves/belrotstaff01.swf-">Sinister Staff of Mana Leech</option>
                                        <Option value="items/axes/CrystalBoneAxe.swf-CrystalBoneAxe">Skele-Crystal Cleaver </option>
                                        <Option value="items/maces/mace08.swf-mace08">Skeleton Hand</option>
                                        <Option value="items/guns/J6SketchShotgun.swf-J6SketchShotgun">Sketchy Shotgun</option>
                                        <Option value="items/staves/SkullCane.swf-">Skull Cane</option>
                                        <Option value="items/swords/DungeonReaver.swf-DungeonReaver">Skullwraith</option>
                                        <Option value="items/swords/SkydriteSwordblue.swf-SkydriteSwordblue">Skydrite's Blue Sword</option>
                                        <Option value="items/swords/SkydriteSword.swf-">Skydrite's Sword</option>
                                        <Option value="items/daggers/SkyGuardSwordShield.swf-SkyGuardSwordShield">Skyguard Blade and Shield</option>
                                        <Option value="items/swords/SkyGuardBlade.swf-SkyGuardBlade">SkyGuard Blade</option>
                                        <Option value="items/swords/SkyguardCrystalBlade.swf-SkyguardCrystalBlade">Skyguard Crystal Blade</option>
                                        <Option value="items/swords/SkyguardFalconBlade.swf-SkyguardFalconBlade">Skyguard Falcon Blade</option>
                                        <Option value="items/polearms/SkyHalberd.swf-SkyHalberd">Skyguard Halberd</option>
                                        <Option value="items/swords/SkyguardHighblade.swf-SkyguardHighblade">Skyguard Highblade</option>
                                        <Option value="items/maces/SorasHourglass.swf-SorasHourglass">Sora's Hourglass</option>
                                        <Option value="items/swords/SoulEaterAdvanced.swf-SoulEaterAdvanced">Soul Eater Advanced</option>
                                        <Option value="items/swords/SoulEaterSword.swf-SoulEaterSword">Soul Eater Sword</option>
                                        <Option value="items/swords/SoulEater.swf-SoulEater">Soul Eater</option>
                                        <Option value="items/swords/Demonkissblade1.swf-">Soul Ripper</option>
                                        <Option value="items/swords/TerrorSword01.swf-TerrorSword01">Soul Terror Sword</option>
                                        <Option value="items/staves/Fireworkstaff1.swf-Fireworkstaff1">Sparkler</option>
                                        <Option value="items/staves/MiltonPoolstaff01.swf-">Spellbound Staff Of Miltonius </option>
                                        <Option value="items/daggers/WheelMiltonPooldagger01Evil.swf-WheelMiltonPooldagger01Evil">Spinal Tap of the Wicked</option>
                                        <Option value="items/daggers/DaggerBackwards.swf-DaggerBackwards">Spirit Assassin Blades</option>
                                        <Option value="items/maces/Spoon.swf-Spoon">Spoon</option>
                                        <Option value="items/daggers/SporkionSpork01.swf-">Sporkion Spork</option>
                                        <Option value="items/staves/staff14.swf-">Sprite's Twig</option>
                                        <Option value="items/swords/SSSBladesword01.swf-SSSBladesword01">SSS Bladesword</option>
                                        <Option value="items/staves/newbiestaff02.swf-">Staff of Casting</option>
                                        <Option value="items/staves/Chaosstaff01.swf-">Staff of Inversion</option>
                                        <Option value="items/staves/staff05.swf-">Staff of Malachite</option>
                                        <Option value="items/staves/staff23.swf-">Staff of Pestilence</option>
                                        <Option value="items/staves/DoomStaff1.swf-DoomStaff1">Staff of Ruin</option>
                                        <Option value="items/staves/SpiderQuibstaff01.swf-SpiderQuibstaff01">Staff of Soul Weaving</option>
                                        <Option value="items/staves/Impstaff1.swf-">Staff of the Burning Abyss</option>
                                        <Option value="items/staves/DragonsConquererStaff.swf-DragonsConquererStaff">Staff of the Dragon Conqueror</option>
                                        <Option value="items/staves/staffofthesun.swf-staffofthesun">Staff of the Sun</option>
                                        <Option value="items/staves/Starstaff01.swf-">Star Caster Staff</option>
                                        <Option value="items/swords/Starsword2.swf-">Star Slasher</option>
                                        <Option value="items/swords/starswordbreaker.swf-starswordbreaker">Star Sword Breaker</option>
                                        <Option value="items/swords/swordStardot.swf-">Stardot's Sword</option>
                                        <Option value="items/swords/StarkIce.swf-StarkIce">Stark's Ice</option>
                                        <Option value="items/guns/SilverCrossbow.swf-SilverCrossbow">Sterling Silver Crossbow</option>
                                        <Option value="items/guns/SilverShotgun.swf-SilverShotgun">Sterling Silver Shotgun</option>
                                        <Option value="items/daggers/dagger02a.swf-">Stinging Dagger of Serpents</option>
                                        <Option value="items/maces/StonedMaul.swf-StonedMaul">Stoned Maul</option>
                                        <Option value="items/swords/StratosphericTachi.swf-StratosphericTachi">Stratospheric Itachi</option>
                                        <Option value="items/swords/StratosphericTachi.swf-StratosphericTachi">Stratospheric Tachi</option>
                                        <Option value="items/swords/sword46.swf-">Sun Sabre</option>
                                        <Option value="items/maces/Mwrench.swf-MWrench">Super Plumber's Wrench</option>
                                        <Option value="items/polearms/Elitespear1.swf-">Superior Guard Spear</option>
                                        <Option value="items/maces/SkyDrgnHammer.swf-SkyDrgnHammer">Supreme Dragon Hammer</option>
                                        <Option value="items/polearms/SkySuprmDrgnScythe.swf-SkySuprmDrgnScythe">Supreme Dragon Scythe</option>
                                        <Option value="items/swords/VoidWeapon3.swf-VoidWeapon3">Swarthy Skean</option>
                                        <Option value="items/staves/staff10a.swf-">Sweeping Broom</option>
                                        <Option value="items/swords/VampirelSwordOfAnimus.swf-VampirelSwordOfAnimus">Sword Of Animus</option>
                                        <Option value="items/swords/Patricksword01.swf-Patricksword01">Sword of Caledonia</option>
                                        <Option value="items/swords/SwordOfCtrl.swf-SwordOfCtrl">Sword of Ctrl</option>
                                        <Option value="items/swords/SwordOfDel.swf-SwordOfDel">Sword Of Del</option>
                                        <Option value="items/swords/SwordOfMasters.swf-SwordOfMasters">Sword Of Masters</option>
                                        <Option value="items/swords/SwordOfMasters.swf-SwordOfMasters">Sword of Masters</option>
                                        <Option value="items/swords/MiltonPoolsword01.swf-MiltonPoolsword01">Sword of Miltonius</option>
                                        <Option value="items/swords/SwordofBat09.swf-">Sword of the Bat</option>
                                        <Option value="items/swords/JewledWeaponEvil.swf-JewledWeaponEvil">Sword of the Vilifier</option>
                                        <Option value="items/swords/Jeweledblade2.swf-">Sword of the Vindicator</option>
                                        <Option value="items/swords/Swordinstone.swf-">Sword out of the Stone</option>
                                        <Option value="items/swords/GiftboxswordMEM.swf-GiftboxswordMEM">Sword Shaped Giftbox</option>
                                        <Option value="items/maces/SwordhavenBattleGuitar.swf-SwordhavenBattleGuitar">Swordhaven Battle Guitar</option>
                                        <Option value="items/daggers/MiltonPoolClaw03.swf-MiltonPoolClaw03">Tainted Claw of Miltonius</option>
                                        <Option value="items/daggers/MiltonPoolTalon01.swf-">Talons Of Miltonius</option>
                                        <Option value="items/swords/WintryTwig.swf-WintryTwig">Tannenbaum's Tinder</option>
                                        <Option value="items/swords/VoidTerror.swf-VoidTerror">Terror of the Void</option>
                                        <Option value="items/maces/dwarfhammer2.swf-">Thag War Hammer</option>
                                        <Option value="items/swords/Crystalblade1.swf-Crystalblade1">The Better Blade</option>
                                        <Option value="items/swords/Playersword04.swf-Playersword04">The Blade of Apparition</option>
                                        <Option value="items/swords/Corporation.swf-Corporation">The Corporation</option>
                                        <Option value="items/swords/DarkHeart.swf-DarkHeart">The Dark Heart</option>
                                        <Option value="items/axes/Frostaxe01.swf-FrostAxe">The Frost Axe</option>
                                        <Option value="items/swords/TreeSword1.swf-TreeSword1">The Frostval Fir</option>
                                        <Option value="items/axes/OrnateGoldAxe.swf-OrnateGoldAxe">The Great Gilead Axe</option>
                                        <Option value="items/swords/VoidCutter.swf-VoidCutter">The Great Void Slasher</option>
                                        <Option value="items/swords/LegionScimi.swf-LegionScimi">The Guiltius</option>
                                        <Option value="items/swords/HollowBlade.swf-HollowBlade">The Hollow Blade</option>
                                        <Option value="items/swords/Infector.swf-Infector">The Infector</option>
                                        <Option value="items/polearms/LQSScythe1.swf-LQSScythe1">The Plague Scythe</option>
                                        <Option value="items/polearms/MiltonPoolRixtypolearm01.swf-MiltonPoolRixtypolearm01">The Rixty Ripper</option>
                                        <Option value="items/staves/Ledgestaff1.swf-Ledgestaff1">The Supreme Arcane Staff</option>
                                        <Option value="items/swords/TheTormenter.swf-TheTormenter">The Tormenter</option>
                                        <Option value="items/swords/Underscoresword01.swf-">The Underscore</option>
                                        <Option value="items/swords/TheUnholy.swf-TheUnholy">The Unholy</option>
                                        <Option value="items/swords/swordWarriorTrainer.swf-">Thok's Disciple</option>
                                        <Option value="items/maces/ThreeLeafClover.swf-ThreeLeafClover">Three Leaf Clover</option>
                                        <Option value="items/swords/ZorboSword1.swf-">Ticklish Zorbo Sword</option>
                                        <Option value="items/swords/TitanioSword.swf-">Titanio's Sword</option>
                                        <Option value="items/swords/NewBlade2.swf-NewBlade2">Titian Avenger</option>
                                        <Option value="items/axes/TomaHawk.swf-TomaHawk">TomaHawk</option>
                                        <Option value="items/staves/Toothbrushstaff01.swf-Toothbrushstaff01">Toothbrush</option>
                                        <Option value="items/maces/Toothchucks.swf-Toothchucks">Toothchucks</option>
                                        <Option value="items/staves/Toothbrushstaff02.swf-">Toothy Staff</option>
                                        <Option value="items/swords/IvyBladeCC.swf-IvyBladeCC">Toxic Ivy Blade</option>
                                        <Option value="items/maces/wrench01.swf-ToyWrench">Toy Maker Wrench</option>
                                        <Option value="items/polearms/Elitespear1easter.swf-">Transforming Spear of the Berzerker Bunny</option>
                                        <Option value="items/polearms/Tridentweapon1.swf-">Trident of Storms</option>
                                        <Option value="items/swords/TriumphantLegacy.swf-TriumphantLegacy">Triumphant Legacy</option>
                                        <Option value="items/swords/TurdrakenScaleSword.swf-TurdrakenScaleSword">Turdraken Scale Sword</option>
                                        <Option value="items/maces/Turkeyleg1.swf-Turkeyleg1">Turkey Leg</option>
                                        <Option value="items/staves/Twigstaff1.swf-">Twilly Twig</option>
                                        <Option value="items/daggers/WheelMiltonPooTwinDagger01CC.swf-WheelMiltonPooTwinDagger01CC">Twin Blade of Miltonius</option>
                                        <Option value="items/daggers/TwinBladesofGaleWarrior.swf-TwinBladesofGaleWarrior">Twin Blades of Gale Warrior</option>
                                        <Option value="items/daggers/TwinDragons.swf-TwinDragons">TwinDragons of Destiny</option>
                                        <Option value="items/daggers/TwistedCleaverDaggers.swf-TwistedCleaverDaggers">Twisted Rippers</option>
                                        <Option value="items/staves/newbiestaff01.swf-">Ugly Stick</option>
                                        <Option value="items/maces/Blank.swf-">Unarmed</option>
                                        <Option value="items/staves/CrystalSkullStaff.swf-CrystalSkullStaff">Undead Avarice Staff</option>
                                        <Option value="items/swords/UndeadChampionBlade.swf-UndeadChampionBlade">Undead Champion Blade</option>
                                        <Option value="items/axes/Voltaireguitar3.swf-">Undead Pirate Guitar</option>
                                        <Option value="items/swords/UndyingCleaver.swf-UndyingCleaver">Undying Cleaver</option>
                                        <Option value="items/daggers/MiltonPoolSecretdagger04.swf-MiltonPoolSecretdagger04">Ungodly Reavers of Miltonius</option>
                                        <Option value="items/daggers/MiltonPoolSecretdagger03.swf-MiltonPoolSecretdagger03">Unholy Reapers of Miltonius</option>
                                        <Option value="items/swords/UnHolyTruth.swf-UnHolyTruth">UnHoly Truth</option>
                                        <Option value="items/guns/MiltonPoolgun01.swf-MiltonPoolgun01">Unidentified 1 - Trig Buster</option>
                                        <Option value="items/axes/axe10A.swf-axe10A">Unidentified 14 - Worn Axe</option>
                                        <Option value="items/staves/WheelMilltoniusStaff02.swf-WheelMilltoniusStaff02">Unidentified 29 - Mysterious Walking Cane</option>
                                        <Option value="items/daggers/WheelMiltonPooldagger05CC.swf-WheelMiltonPooldagger05CC">Unidentified 33 - Primal Dagger Tooth</option>
                                        <Option value="items/swords/Valoroth.swf-Valoroth">Valoroth Sword</option>
                                        <Option value="items/swords/Valoroth.swf-Valoroth">Valoroth</option>
                                        <Option value="items/polearms/PlayerScythe2.swf-PlayerScythe2">Vampwing</option>
                                        <Option value="items/swords/Chaosvenomhead.swf-">Venom Head of Chaos</option>
                                        <Option value="items/swords/sword06.swf-sword06">Venom Head</option>
                                        <Option value="items/swords/StratosSword.swf-StratosSword">Vindication of the Lost</option>
                                        <Option value="items/staves/Glowstick5.swf-">Violet GlowStick</option>
                                        <Option value="items/swords/IrishSword1.swf-IrishSword1">Viridian Twist Sword</option>
                                        <Option value="items/swords/Virtue.swf-Virtue">Virtue</option>
                                        <Option value="items/maces/VoidBouquet1.swf-VoidBouquet1">Void Bouquet</option>
                                        <Option value="items/maces/VoidBouquet1.swf-VoidBouquet1">Void Bouquet</option>
                                        <Option value="items/swords/sword48.swf-">Void Reaver</option>
                                        <Option value="items/swords/MiltonPoolsword06.swf-MiltonPoolsword06">Voidfangs of Miltonius</option>
                                        <Option value="items/swords/Voidsword01.swf-Voidsword01">Voidsplinter Crystal</option>
                                        <Option value="items/daggers/Voiddagger01.swf-Voiddagger01">Voidsplinter Shards</option>
                                        <Option value="items/staves/Voidstaff01.swf-Voidstaff01">Voidsplinter Tether</option>
                                        <Option value="items/axes/Voltaireguitar1.swf-">Voltaire's Guitar</option>
                                        <Option value="items/swords/VoltaireRapier.swf-">Voltaire's Rapier</option>
                                        <Option value="items/axes/VorutanianKeyBlade.swf-VorutanianKeyBlade">Vorutanian Key Blade</option>
                                        <Option value="items/swords/VulcansMight.swf-VulcansMight">Vulcan's Might</option>
                                        <Option value="items/guns/gun01.swf-">Wallo's Gun</option>
                                        <Option value="items/swords/CJsword.swf-CJsword">Warmonger's DOOMBLADE</option>
                                        <Option value="items/swords/beamswordBlack.swf-">WarpForce Black Beamsword</option>
                                        <Option value="items/swords/beamswordBlue.swf-">WarpForce Blue Beamsword</option>
                                        <Option value="items/swords/beamswordGreen.swf-">WarpForce Green Beamsword</option>
                                        <Option value="items/guns/heavygun.swf-heavygun">WarpForce Heavy Gun</option>
                                        <Option value="items/swords/beamswordRed.swf-">WarpForce Red Beamsword</option>
                                        <Option value="items/maces/WFWarShovel20K.swf-WFWarShovel20K">WarpForce War Shovel 20K</option>
                                        <Option value="items/swords/beamswordYellow.swf-">WarpForce Yellow Beamsword</option>
                                        <Option value="items/swords/sword16.swf-">Warrior Claymore Blade</option>
                                        <Option value="items/daggers/AtariDaggers.swf-AtariDaggers">WASDaggers</option>
                                        <Option value="items/swords/IceyWingBlade.swf-IceyWingBlade">Wing of the Frost Griffin</option>
                                        <Option value="items/staves/NytherasStaff.swf-NytherasStaff">Winged Jewel of the Dragon</option>
                                        <Option value="items/maces/WEMasStick.swf-WEMasStick">Winter-een-mas Scepter</option>
                                        <Option value="items/maces/Mace_Temp.swf-">Wooden Mallet</option>
                                        <Option value="items/daggers/stake1.swf-">Wooden Stake</option>
                                        <Option value="items/staves/staff02.swf-">Wrath of Sciurus</option>
                                        <Option value="items/maces/spork1.swf-">Wyrm's Spork</option>
                                        <Option value="items/staves/ElevenStaff.swf-ElevenStaff">Year of Chemistry Staff</option>
                                        <Option value="items/staves/Glowstick2.swf-">Yellow GlowStick</option>
                                        <Option value="items/staves/YokiBo.swf-YokiBo">YokiBo</option>
                                        <Option value="items/maces/mug1.swf-">Yulgar's Berry Mug</option>
                                        <Option value="items/staves/zazrazor.swf-">Zazrazor</option>
                                        <Option value="items/polearms/Spiderpolearm01.swf-">Zazul's Spider Polearm</option>
                                        <Option value="items/daggers/ZealithReaver.swf-ZealithReaver">Zealith Reaver</option>
                                        <Option value="items/swords/ZeoKnightBlade.swf-ZeoKnightBlade">ZeoKnight Blade</option>
                                        <Option value="items/swords/Zheenx.swf-zhooenx2">Zheenx Sword</option>
                                        <Option value="items/axes/ZhiloAxe.swf-ZhiloAxe">Zhilo's Axe</option>
                                        <Option value="items/bows/Zbow16bit.swf-Zbow16bit">Zhoom's 16-bit Shortbow</option>
                                        <Option value="items/bows/bow02.swf-">Zhoom's Bow</option>
                                        <Option value="items/bows/ZhoomBow2.swf-ZhoomBow2">Zhoom's Dragonbow</option>
                                        <Option value="items/bows/OmegaShot1.swf-OmegaShot1">Omega Shot</option>
                                        <Option value="items/guns/OmegaManaBurster1.swf-OmegaManaBurster1">Omega Manaburster</option>
                                        <Option value="items/guns/OmegaM191.swf-OmegaM191">Omega M19</option>
                                        <Option value="items/daggers/OmegaTonfa1.swf-OmegaTonfa1">Omega Tonfa</option>
                                        <Option value="items/daggers/OmegaDotanuki1.swf-OmegaDotanuki1">Omega Dotanuki</option>
                                        <Option value="items/guns/OmegaClappers1.swf-OmegaClappers1">Omega Clappers</option>
                                        <Option value="items/daggers/SteamGearDaggers.swf-SteamGearDaggers">Dire Daggers</option>
                                        <Option value="items/daggers/CombatCutters1.swf-CombatCutters1">Combat Cutters</option>
                                        <Option value="items/axes/Thunderclap.swf-Thunderclap">Electric Thunder</option>
                                        <Option value="items/swords/UnderScoreEvil.swf-UnderScoreEvil">The Overscore</option>
                                        <Option value="items/swords/UltimaFire.swf-UltimaFire">Ultima Thermos</option>
                                        <Option value="items/guns/BlackWireWhip.swf-BlackWireWhip">Black Wire Whip</option>
                                        <Option value="items/swords/DeadyKatana.swf-DeadyKatana">Deady Sized Sword</option>
                                        <Option value="items/staves/Zap.swf-Zap">Ionic Discharge</option>
                                        <Option value="items/swords/SwordOfSanctuary.swf-SwordOfSanctuary">Sword of Sanctuary</option>
                                        <Option value="items/capes/RideTheLightning.swf-RideTheLightning">Lightning Edge</option>
                                        <Option value="items/guns/RekiGun.swf-RekiGun">Piercing Light</option>
                                        <Option value="items/daggers/SoulStrippers.swf-SoulStrippers">SoulStrippers</option>
                                        <Option value="items/daggers/DigitalTerror.swf-DigitalTerror">Digital Terror</option>
                                        <Option value="items/guns/ShotgunJ616bit.swf-ShotgunJ616bit">J6's Digital Shotgun</option>
                                        <Option value="items/bows/PlasmidBow.swf-PlasmidBow">Plasmid Bow</option>
                                        <Option value="items/guns/RedWireWhip.swf-RedWireWhip">Red Wire Whip</option>
                                        <Option value="items/polearms/HarvestingSpear.swf-HarvestingSpear">Soul Harvest Spear</option>
                                    </select></td>
                                <td><select onChange="javascript:makecode()" NAME="weaponType" ID="weaponType">
                                        <Option value="Sword">Sword</option>
                                        <Option value="Dagger">Dagger</option>
                                        <Option value="Staff">Staff</option>
                                        <Option value="Gun">Gun</option>
                                        <Option value="Polearm">Polearm</option>
                                        <Option value="Axe">Axe</option>
                                        <Option value="Mace">Mace</option>
                                    </select></td>
                            </tr>
                            <tr>
                                <td><b><img src="images/cape.png" width="15px" /> Cape:</b></td>
                                <td style="display:none;"><input onChange="javascript:ChangeItem('cape')" type="text" name="bafile" value="<?php echo $bafile; ?>"></td>
                                <td style="display:none;"><input onChange="javascript:ChangeItem('cape')" type="text" name="balink" value="<?php echo $balink; ?>"></td>
                                <td style="display:none;"><input onChange="javascript:ChangeItem('cape')" type="text" name="baname" value="<?php echo $baname; ?>"></td>
                                <td><select id="cape" onChange="javascript:ChangeItem('cape')" NAME="CapeSelect">
                                        <Option value="items/capes/redcape.swf-RedCape">Red Cape</option>
                                        <Option value="none-none">None</option>
                                        <Option value="items/capes/Foxtail3.swf-Foxtail3">7 Tail Fox</option>
                                        <Option value="items/capes/Aishacape.swf-Aishacape">Aisha's Cape</option>
                                        <Option value="items/capes/RuneCapeWater.swf-RuneCapeWater">Aquatic Runes</option>
                                        <Option value="items/capes/MiltonPoolCloak4.swf-MiltonPoolCloak4">Archfiend Cloak of Miltonius</option>
                                        <Option value="items/capes/UltraDSCape.swf-UltraDSCapel">Arctic Dragonslayer Cloak</option>
                                        <Option value="items/capes/cloak4.swf-Cloak4">Aristocratic Cloak</option>
                                        <Option value="items/capes/arrowquiver1.swf-arrowquiver1">Arrow Quiver</option>
                                        <Option value="items/capes/AstralRune.swf-AstralRune">Astral Runes</option>
                                        <Option value="items/capes/PlatinumWingsEvil.swf-PlatinumWingsEvil">Atramentous Wings</option>
                                        <Option value="items/capes/backblades01.swf-backblades01">Back Frost Blades</option>
                                        <Option value="items/capes/backblades03.swf-backblades03">Barbarian Sheathed Blade</option>
                                        <Option value="items/capes/XboxCloak1.swf-XboxCloak1">Battle Zeke Cloak</option>
                                        <Option value="items/capes/Beachtowel1.swf-Beachtowel1">Beach Towel</option>
                                        <Option value="items/capes/chaosbearcape.swf-chaosbearcape">Bear Skin Cloak</option>
                                        <Option value="items/capes/grim2cape.swf-Grim2Cape">Blood Cloak</option>
                                        <Option value="items/capes/fourthbluecape.swf-fourthbluecape">Blue Flag Cloak</option>
                                        <Option value="items/capes/KappaShell2.swf-KappaShell2">Blue Kappa Shell</option>
                                        <Option value="items/capes/BatBladeCape.swf-BatBladeCape">Bounded Bat Broad Blade</option>
                                        <Option value="items/capes/drowcloak.swf-drowcloak">Breethen D'irt Cloak</option>
                                        <Option value="items/capes/easterrabbitcape.swf-easterrabbitcape">Bunny on your Back</option>
                                        <Option value="items/capes/Longcape1.swf-Longcape1">Cape of Giants</option>
                                        <Option value="items/capes/GiftboxcapeMEM.swf-GiftboxcapeMEM">Cape Shaped Giftbox</option>
                                        <Option value="items/capes/CardCape.swf-CardCape">CardCape</option>
                                        <Option value="items/capes/cloak1.swf-cloak1">Cardinal Cloak</option>
                                        <Option value="items/capes/CelticGreenCape.swf-CelticGreenCape">Celtic Caster Wrap</option>
                                        <Option value="items/capes/ChaosWarriorWing.swf-ChaosWarriorWings">Chaos Warrior Wings</option>
                                        <Option value="items/capes/ChestofBooty.swf-ChestofBooty">Chest Of Booty</option>
                                        <Option value="items/capes/ChronomancerClockCape.swf-ChronomancerClockCape">Chrono Clock</option>
                                        <Option value="items/capes/bannergrad01.swf-bannergrad01">Class of 2000 Banner</option>
                                        <Option value="items/capes/frostcape01.swf-frostcape01">Cloak of Blizzard</option>
                                        <Option value="items/capes/NinjaCloak.swf-NinjaCloak">Cloak of Clouds - Akatsuki Cape</option>
                                        <Option value="items/capes/ShadowCloak1.swf-ShadowCloak1">Cloak of Dragonwings</option>
                                        <Option value="items/capes/MiltonPoolCloak1.swf-MiltonPoolCloak1">Cloak of Miltonius</option>
                                        <Option value="items/capes/Frozencape1.swf-Frozencape1">Cloak of the North Wind</option>
                                        <Option value="items/capes/VathCloak1.swf-VathCloak1">Cloak of Vath</option>
                                        <Option value="items/capes/CelSandWingsClosed3.swf-CelSandWingsClosed">Closed Celestial Sandwings</option>
                                        <Option value="items/capes/ClothWings.swf-ClothWings">Cloth Wings</option>
                                        <Option value="items/capes/giftbag2_r1.swf-giftbag2">Cracked Egg Backpack</option>
                                        <Option value="items/capes/CrossedSwordsCape.swf-CrossedSwordsCape">Crossed Swords Cape</option>
                                        <Option value="items/capes/ParagonCape.swf-ParagonCape">Dage's Paragon Cape</option>
                                        <Option value="items/capes/DaintyPartyWings1.swf-DaintyPartyWings1">Dainty Party Wings</option>
                                        <Option value="items/capes/DarkCasterCape.swf-DarkCasterCape">Dark Caster Cape</option>
                                        <Option value="items/capes/wings8.swf-Wings8">Dark Draconian Wings</option>
                                        <Option value="items/capes/wings5.swf-Wings5">Dark Floating Wings</option>
                                        <Option value="items/capes/darkbluecape.swf-DarkblueCape">Darkblue Cape</option>
                                        <Option value="items/capes/DerpWings.swf-DerpWings">Derpy White Wings</option>
                                        <Option value="items/capes/doomfire.swf-doomfire">Doom Fire</option>
                                        <Option value="items/capes/tentacles2.swf-Tentacles2">Doom Worm Creepers</option>
                                        <Option value="items/capes/CNYDragonTail.swf-CNYDragonTail">Dragon Dance Tail</option>
                                        <Option value="items/capes/wingsdragon1.swf-Wingsdragon1">Dragon Wings</option>
                                        <Option value="items/capes/MiltonPoolCloak2.swf-MiltonPoolCloak2">Dread Heads of Miltonius</option>
                                        <Option value="items/capes/ShadowWings1.swf-ShadowWings1">Dread Wings</option>
                                        <Option value="items/capes/Greenlove.swf-Greenlove">Emerald Eternal Flame</option>
                                        <Option value="items/capes/Burninglove.swf-Burninglove">Eternal Flame</option>
                                        <Option value="items/capes/CADCape.swf-CADCape">Ethan's Cape</option>
                                        <Option value="items/capes/ClawSuitAdvancedCape.swf-ClawSuitAdvancedCape">Evolved Clawspikes</option>
                                        <Option value="items/capes/fireworks1.swf-fireworks1">Explosive Rocket Backpack</option>
                                        <Option value="items/capes/FearFearWings.swf-FearFearWings">Fear's Wings</option>
                                        <Option value="items/capes/belrotarms.swf-belrotarms">Fiend Clawed Back Appendages</option>
                                        <Option value="items/capes/MiltonPoolCloak3.swf-MiltonPoolCloak3">Fiend Cloak of Miltonius</option>
                                        <Option value="items/capes/imptail1.swf-imptail1">Fire Imp Tail</option>
                                        <Option value="items/capes/wings2.swf-Waing2Cape">Floating Wings</option>
                                        <Option value="items/capes/SkyGuardCape.swf-SkyGuardCape">Formal Skyguard Cape</option>
                                        <Option value="items/capes/Foxtail1.swf-Foxtail1">Foxtail</option>
                                        <Option value="items/capes/Frostwing1.swf-Frostwing1">Frost Drake Wings</option>
                                        <Option value="items/capes/FrostvalFur.swf-FrostvalFur">Frostval Fur Cloak</option>
                                        <Option value="items/capes/giftbag1.swf-giftbag1">Giant Sack of Gifts</option>
                                        <Option value="items/capes/AstralLightWings.swf-AstralLightWings">Gnosis Wings</option>
                                        <Option value="items/capes/wings7.swf-Wings7">Golden Draconian Wings</option>
                                        <Option value="items/capes/GoldenMoglinCape.swf-GoldenMoglinCape">Golden Moglin on your back</option>
                                        <Option value="items/capes/golfBag.swf-GolfCape">Golf Bag</option>
                                        <Option value="items/capes/grandcape1.swf-grandcape1">Grand Inquisitor Cloak</option>
                                        <Option value="items/capes/GraverobbersCloak1.swf-GraverobbersCloak1">Grave Robber's Cloak</option>
                                        <Option value="items/capes/ChaosCrystalcape.swf-ChaosCrystalcape">Gravitating Chaos Crystal</option>
                                        <Option value="items/capes/gravityrocks1.swf-gravityrocks1">Gravity Cloak</option>
                                        <Option value="items/capes/tentacles3.swf-Tentacles3">Great Pumpkin King's Great Vines</option>
                                        <Option value="items/capes/parrot1.swf-Parrot1Cape">Green Parrot on your Shoulder</option>
                                        <Option value="items/capes/SpiderBOSSLegs1.swf-SpiderBOSSLegs1">Gressils Spider Legs</option>
                                        <Option value="items/capes/grimcape.swf-GrimCape">Grim Cloak</option>
                                        <Option value="items/capes/GuardianShadowCape.swf-GuardianShadowCape">Guardian Shadow</option>
                                        <Option value="items/capes/PinkMoglinCape.swf-PinkMoglinCape">Hangin' Around Pink Moglin</option>
                                        <Option value="items/capes/goodcape1.swf-goodcape1">Highborn Cloak</option>
                                        <Option value="items/capes/UndeadParrot2.swf-UndeadParrot2">Icy Undead Parrot</option>
                                        <Option value="items/capes/ShadowSwordsGoodVersion.swf-ShadowSwordsGoodVersion">Integrity Blades</option>
                                        <Option value="items/capes/IronButterfly.swf-IronButterfly">Iron Butterfly Wings</option>
                                        <Option value="items/capes/J6Gattling.swf-J6Gattling">J6's Gatling Gun</option>
                                        <Option value="items/capes/JollyRoger.swf-JollyRoger">Jolly Roger</option>
                                        <Option value="items/capes/TenguWings2.swf-TenguWings2">Karasu Wings</option>
                                        <Option value="items/capes/FishTailOrangeKoi.swf-FishTailOrangeKoi">Koi's Fish Tail</option>
                                        <Option value="items/capes/RainbowWings1.swf-RainbowWings1">Luckiest Lorikeet Feathers</option>
                                        <Option value="items/capes/CelticGreenCape2.swf-CelticGreenCape2">Lucky Broadsword on your Back</option>
                                        <Option value="items/capes/LuckyGoldCape1.swf-LuckyGoldCape1">Lucky Gold Cape</option>
                                        <Option value="items/capes/CelticButterflyWings1.swf-CelticButterflyWings1">Lucky Lycaena Wings</option>
                                        <Option value="items/capes/FlameWings.swf-FlameWings">Mafic Wings</option>
                                        <Option value="items/capes/MaximillianCape.swf-MaximillianCape">Maximillian’s Cape</option>
                                        <Option value="items/capes/MoglinDefenderTail.swf-MoglinDefenderTail">Moglin Defender Tail</option>
                                        <Option value="items/capes/monkey.swf-MonkeyCape">Monkey on your back!</option>
                                        <Option value="items/capes/AstronautPack.swf-AstronautPack">Moonwalker Pack</option>
                                        <Option value="items/capes/PVPNecroCape3.swf-PvPNecroCape3">Necrotized Broadsword Battle-Cape</option>
                                        <Option value="items/capes/NekoyashaMain.swf-NekoyashaMain">Nekoyasha Mane</option>
                                        <Option value="items/capes/NightShockWings.swf-NightShockWings">Night Shock Wings</option>
                                        <Option value="items/capes/NightShockWings.swf-NightShockWings">Nightshock Wings</option>
                                        <Option value="items/capes/cloak2.swf-Cloak2">Noble Cloak</option>
                                        <Option value="items/capes/NyctoxCape.swf-NyctoxCape">Nyctox's Cloak</option>
                                        <Option value="items/capes/NytheraCape.swf-NytheraCape">Nythera's Cape</option>
                                        <Option value="items/capes/NytheraWings1.swf-NytheraWings1">Nythera's Wings</option>
                                        <Option value="items/capes/YokaiOdokuroBack.swf-YokaiOdokuroBack">O-dokuro on Your Back</option>
                                        <Option value="items/capes/OctopusCape.swf-OctopusCape">Octopus Backpack</option>
                                        <Option value="items/capes/odanatacape.swf-OdanataCape">Odanata Wings</option>
                                        <Option value="items/capes/CelSandWingsOpen.swf-CelSandWingsOpen">Open Celestial Sandwings</option>
                                        <Option value="items/capes/OrnateLongBowCape.swf-OrnateLongBowCape">Ornate Long Bow on your back</option>
                                        <Option value="items/capes/pandacannon.swf-pandacannon">Panda Launcher</option>
                                        <Option value="items/capes/pinkcape.swf-pinkcape">Pink Cape</option>
                                        <Option value="items/capes/tpcape.swf-tpcape">Port-A-Pwnzor Cloak</option>
                                        <Option value="items/capes/CatTailCC.swf-CatTailCC">Prismatic Cat's Tail</option>
                                        <Option value="items/capes/DracwingsCC.swf-DracwingsCC">Prismatic Draconian Wings</option>
                                        <Option value="items/capes/FairyWings1CC.swf-FairyWings1CC">Prismatic Sidhe Wings</option>
                                        <Option value="items/capes/DoubleWings1.swf-DoubleWings1">Prismatic Wings Of The Wind</option>
                                        <Option value="items/capes/PrometheusCape.swf-PrometheusCape">Prometheus Rings</option>
                                        <Option value="items/capes/wings3.swf-Wings3Cape">Purple Draconian Wings</option>
                                        <Option value="items/capes/RazorWings.swf-RazorWings">Razor Wings</option>
                                        <Option value="items/capes/redridingcape1.swf-redridingcape1">Red Riding Cape</option>
                                        <Option value="items/capes/RocketQuiver.swf-RocketQuiver">Revolutionary Quiver</option>
                                        <Option value="items/capes/jetpack.swf-JetpackCape">Rocket Pack</option>
                                        <Option value="items/capes/RottenWings1.swf-RottenWings1">Rotting Wraithwings</option>
                                        <Option value="items/capes/RoyalGuardCape.swf-RoyalGuardCape">Royal Guard Cape</option>
                                        <Option value="items/capes/saloondoors.swf-saloondoors">Saloon Door Wings</option>
                                        <Option value="items/capes/Sanguinewings1.swf-Sanguinewings1">Sanguine's Wings</option>
                                        <Option value="items/capes/clawback2.swf-clawback2">Santa's Colorful Backblades</option>
                                        <Option value="items/capes/ScorpionTail1.swf-ScorpionTail1">Scorpion Tail</option>
                                        <Option value="items/capes/SekCape1.swf-SekCape1">Sek-Duat Cloak</option>
                                        <Option value="items/capes/ShadowSwords1.swf-ShadowSwords1">Shadow Blades</option>
                                        <Option value="items/capes/ShamrockCape1.swf~ShamrockCape1">Shamrock Cape</option>
                                        <Option value="items/capes/SharkmanCape.swf-SharkmanCape">SharkBait's Fin</option>
                                        <Option value="items/capes/WintryWings2.swf-WintryWings2">Shimmering Flakes</option>
                                        <Option value="items/capes/SketchyShotgunCape.swf-SketchyShotgunCape">Sketchy Sheathed Shotgun</option>
                                        <Option value="items/capes/MetalicWings.swf-MetalicWings">Skyrenders</option>
                                        <Option value="items/capes/snowballthrower.swf-snowballthrower">Snowball Trebuchet</option>
                                        <Option value="items/capes/frostback1.swf-frostback1">Snowman Head Display</option>
                                        <Option value="items/capes/spiderlegs1.swf-Spiderlegs1">Spider Legs</option>
                                        <Option value="items/capes/FishTailOrangeKoi.swf-FishTailOrangeKoi">Sweetish Fish Tail</option>
                                        <Option value="items/capes/SwordsOfCourage.swf-SwordsOfCourage">Swords Of Courage</option>
                                        <Option value="items/capes/TaintedWings.swf-TaintedWings">Tainted Wings</option>
                                        <Option value="items/capes/WintryWings1.swf-WintryWings1">Tannenbaum Trimmings</option>
                                        <Option value="items/capes/Blackknightcape1a.swf-Blackknightcape1a">Tattered Cape</option>
                                        <Option value="items/capes/tentacles1.swf-Tentacles1Cape">Tentacles of the Overlord</option>
                                        <Option value="items/capes/backblades02.swf-backblades02">Titan's Colossal Sheathed Sword</option>
                                        <Option value="items/capes/TurDCape.swf-TurDCape">Turdraken Down Cloak</option>
                                        <Option value="items/capes/Blackknightcape1.swf-Blackknightcape1">UnderWorld Cloak</option>
                                        <Option value="items/capes/MiltonPoolColorcustomizable.swf-MiltonPoolColorcustomizable">Unidentified 27</option>
                                        <Option value="items/capes/skeletonkey01.swf-skeletonkey01">Unlucky Skeleton Key</option>
                                        <Option value="items/capes/vampirecape1.swf-Vampirecape1">Vampire Cape</option>
                                        <Option value="items/capes/wings11.swf-Wings11">Venom Draconian Wings</option>
                                        <Option value="items/capes/VioletEternalFlame1.swf-VioletEternalFlame1">Violet Eternal Flame</option>
                                        <Option value="items/capes/CCVoidParasiteWings1.swf-CCVoidParasiteWings1">Void Parasite Wings</option>
                                        <Option value="items/capes/VultureWings.swf-VultureWings">Vulture Wings</option>
                                        <Option value="items/capes/MummyCapeDrop.swf-MummyCapeDrop">War Mummy Wrap</option>
                                        <Option value="items/capes/backblades04.swf-backblades04">Warlord Backblades</option>
                                        <Option value="items/capes/wings10.swf-Wings10">Water Draconian Wings</option>
                                        <Option value="items/capes/WerePyreSlayerWings.swf-WerePyreSlayerWings">Werepyre Slayer Wings</option>
                                        <Option value="items/capes/fourthwhitecape.swf-fourthwhitecape">White Flag Cloak</option>
                                        <Option value="items/capes/FurCloakWhite.swf-FurCloakWhite">White Fur Cloak</option>
                                        <Option value="items/capes/wingsdragon2.swf-wingsdragon2">Wings of Darkness</option>
                                        <Option value="items/capes/demonwing.swf-DemonwingCape">Wings of the Abyss</option>
                                        <Option value="items/capes/EgyptWings1.swf-EgyptWings1">Wings of the Pharaoh</option>
                                        <Option value="items/capes/WyrmWings1.swf-WyrmWings1">Wyrm's Wings</option>
                                        <Option value="items/capes/SteamGearBox.swf-SteamGearBox">SteamGear Gilded Coffin</option>
                                        <Option value="items/capes/jetpacksteam.swf-jetpacksteam">Skyguard Flightpack</option>
                                        <Option value="items/capes/SkeleCaptainCape.swf&strCapeLink-SkeleCaptainCape">SkeleCommander's Cape</option>
                                        <Option value="items/capes/RideTheLightning.swf-RideTheLightning">Ride The Lightning</option>
                                        <Option value="items/capes/guitarcape.swf-guitarcape">Electric Axe on your Back</option>
                                    </select><td>
                            </tr>
                            <tr>
                                <td><b><img src="images/helm.png" width="15px" /> Helm:</b></td>
                                <td style="display:none;"><input onChange="javascript:ChangeItem('helm')" type="text" name="helmfile" value="<?php echo $helmhair; ?>"></td>
                                <td style="display:none;"><input onChange="javascript:ChangeItem('helm')" type="text" name="helmlink" value="<?php echo $helmhairl; ?>"></td>
                                <td style="display:none;"><input onChange="javascript:ChangeItem('helm')" type="text" name="helmname" value="<?php echo $helmname; ?>"></td>
                                <td><select id="helm" onChange="javascript:ChangeItem('helm')" NAME="HelmSelect">
                                        <Option value="none-none">None</option>
                                        <Option value="items/helms/BirthdayHelm1.swf-BirthdayHelm1">1st Birthday Cake Helm</option>
                                        <Option value="items/helms/Escherionhelm2.swf-Escherionhelm2">1st Lord Of Chaos Helm</option>
                                        <Option value="items/helms/AcornHelm.swf-AcornHelm">Acorn Guard</option>
                                        <Option value="items/helms/Aishaface.swf-Aishaface">Aisha's Face</option>
                                        <Option value="items/helms/FoxHead2.swf-FoxHead2">Alpha Male Fox Head Morph</option>
                                        <Option value="items/helms/footballhelmsaints.swf-footballhelmsaints">Angel Avengers</option>
                                        <Option value="items/helms/AnubisHelm.swf-AnubisHelm">Anubis Helm</option>
                                        <Option value="items/helms/Applehelm1.swf-Applehelm1">Apple Head the Arrow Magnet</option>
                                        <Option value="items/helms/UltraDSHelm.swf-UltraDSHelm">Arctic Dragonslayer Trophy</option>
                                        <Option value="items/helms/AsgardianHelm.swf-AsgardianHelm">Asgardian Helm</option>
                                        <Option value="items/helms/Aviator2.swf-Aviator2">Aviator Goggles</option>
                                        <Option value="items/helms/BanisherMaskGold.swf-BanisherMaskGold">Banisher Mask</option>
                                        <Option value="items/helms/ClawSAHelm.swf-ClawSAHelm">Battle Clawshelm</option>
                                        <Option value="items/helms/ClawSAHelm.swf-ClawSAHelm">Battle Clawshelmet</option>
                                        <Option value="items/helms/crown2.swf-Crown2">Battle Crown</option>
                                        <Option value="items/helms/BTAMasterHelm.swf-BTAMasterHelm">Battle Tested Axe Master Helm</option>
                                        <Option value="items/helms/indian03.swf-Indian03">Beaded Native Headband</option>
                                        <Option value="items/helms/GloryHelmBeard.swf-GloryHelmBeard">Bearded Helm of Glory</option>
                                        <Option value="items/helms/GiftboxhelmMEM.swf-GiftboxhelmMEM">Bearded Helm Shaped Giftbox</option>
                                        <Option value="items/helms/BandanaCursedBlack.swf-BandanaCursedBlack">Black Cursed Bandana</option>
                                        <Option value="items/helms/BlackKnighthelm1a.swf-BlackKnighthelm1a">Black Knight Cover</option>
                                        <Option value="items/helms/BladeMasterHairFemale.swf-BladeMasterHairFemale">Blade Master Hair Female</option>
                                        <Option value="items/helms/BladeMasterHair.swf-BladeMasterHair">Blade Master Hair</option>
                                        <Option value="items/helms/Blakkhat1.swf-Blakkhat1">Blakk's Hat v2</option>
                                        <Option value="items/helms/Blakkhat2.swf-Blakkhat2">Blakk's Hat</option>
                                        <Option value="items/helms/MiltonPoolBlood1.swf-MiltonPoolBlood1">Blood Guard Of Miltonius</option>
                                        <Option value="items/helms/footballhelm2.swf-footballhelm2">Blood Hawk Helm</option>
                                        <Option value="items/helms/Snugbear1M.swf-Snugbear1M">Blue Snug Helm</option>
                                        <Option value="items/helms/BolesHelm.swf-BolesHelm">Boles' Helm</option>
                                        <Option value="items/helms/Terrorhelm1.swf-Terrorhelm1">Bone Terror Skull</option>
                                        <Option value="items/helms/skullhead2.swf-Skullhead2">Bonehead</option>
                                        <Option value="items/helms/bonnet1.swf-Bonnet1">Bonnet</option>
                                        <Option value="items/helms/bowler.swf-Bowler">Bowler hat</option>
                                        <Option value="items/helms/goggles.swf-Goggles">Boy Goggles</option>
                                        <Option value="items/helms/Fedora1.swf-Fedora1">Brown Fedora</option>
                                        <Option value="items/helms/Warlordhelm1.swf-Warlordhelm1">Brutal Warlord Guard</option>
                                        <Option value="items/helms/BucketHead.swf-BucketHead">Bucket Head</option>
                                        <Option value="items/helms/PotofGoldHat.swf-PotofGoldHat">Bucket O'Gold</option>
                                        <Option value="items/helms/BrazillianHelm.swf-BrazillianHelm">Capacete Brasileiro</option>
                                        <Option value="items/helms/CRMale.swf-CRMale">Carpet Racer Helmet</option>
                                        <Option value="items/helms/CatEars1.swf-CatEars1">Cat Ear Headband</option>
                                        <Option value="items/helms/ears1.swf-Ears1">Cat Ears</option>
                                        <Option value="items/helms/Knight3.swf-Knight3">Cavalier Guard</option>
                                        <Option value="items/helms/CelSandHelm2.swf-CelSandHelm2">Celestial Sandhelm</option>
                                        <Option value="items/helms/CelSandHelm1.swf-CelSandHelm1">Celestial Sandknight Armet</option>
                                        <Option value="items/helms/CelticMageHood.swf-CelticMageHood">Celtic Caster Hood</option>
                                        <Option value="items/helms/CelticAssassinHood.swf-CelticAssassinHood">Celtic Cutthroat Hood</option>
                                        <Option value="items/helms/CelticWarriorHelm.swf-CelticWarriorHelm">Celtic Destroyer Helm</option>
                                        <Option value="items/helms/chaosbearhelm.swf-chaosbearhelm">Chaos Bear Head</option>
                                        <Option value="items/helms/Santa5_Helm.swf-Santa5_Helm">Chaos Claws Helm</option>
                                        <Option value="items/helms/DragonlordChaos1.swf-DragonlordChaos1">Chaos Dragonlord Helm</option>
                                        <Option value="items/helms/knight2.swf-Knight2">Chaos Lord Helm</option>
                                        <Option value="items/helms/ChaosShaperHelm.swf-ChaosShaperHelm">Chaos Shaper Helm</option>
                                        <Option value="items/helms/chaoswarriormask.swf-ChaosWarriorMask">Chaos Warrior Masks</option>
                                        <Option value="items/helms/SpiderChaoshelm.swf-SpiderChaoshelm">Chaos Widow Morph</option>
                                        <Option value="items/helms/chefhat1.swf-Chefhat1">Chef Hat</option>
                                        <Option value="items/helms/ChickenManHelm.swf-ChickenManHelm">Chickenman Hood</option>
                                        <Option value="items/helms/ChopperHelm1.swf-ChopperHelm1">Chopped Chopper Helm</option>
                                        <Option value="items/helms/FatPandaHelm.swf-FatPandaHelm">Chubs the Panda Morph</option>
                                        <Option value="items/helms/Hat2010.swf-Hat2010">Classy New Year's Hat</option>
                                        <Option value="items/helms/GrimSanta.swf-grimsanta">Claws Hood</option>
                                        <Option value="items/helms/SantaCC.swf-SantaCC">Color Custom Santa Hat</option>
                                        <Option value="items/helms/orchelm.swf-orchelm">Conical Hat</option>
                                        <Option value="items/helms/Test_Corinthian.swf-Corinthian">Corinthian Helmet </option>
                                        <Option value="items/helms/Darklord2.swf-Darklord2">Corrupted Dark Lord</option>
                                        <Option value="items/helms/maliciousintent.swf-maliciousintent">Cowl of Malicious Intent</option>
                                        <Option value="items/helms/CreeperHelm2aMiltonius.swf-CreeperHelm2aMiltonius">Creeper Crown</option>
                                        <Option value="items/helms/CrushedTopHat.swf-CrushedTopHat">Crushed Top Hat</option>
                                        <Option value="items/helms/CursedCaptainhat1.swf-CursedCaptainhat1">Cursed Captain's Elegant Hat</option>
                                        <Option value="items/helms/DagesDeathKnightHelm.swf-DagesDeathKnightHelm">Dage's DeathKnight Helm</option>
                                        <Option value="items/helms/UndeadGodlyHelmDage.swf-UndeadGodlyHelmDage">Dage's Godly Helm</option>
                                        <Option value="items/helms/ParagonHelm.swf-ParagonHelm">Dage's Paragon Helm</option>
                                        <Option value="items/helms/DagePumpkinHead.swf-DagePumpkinHead">Dage's Pumpkin Head</option>
                                        <Option value="items/helms/DarkCasterHairBHat.swf-DarkCasterHairBHat">Dark Caster Bday Hat</option>
                                        <Option value="items/helms/darkcasterhair.swf-DarkCasterHair">Dark Caster Hair</option>
                                        <Option value="items/helms/Darkhunger.swf-Darkhunger">Dark Hunger</option>
                                        <Option value="items/helms/darthmaul.swf-DarthMaul">Darth Maul's Helm</option>
                                        <Option value="items/helms/DavidChicken.swf-DavidChicken">David's Chicken Hood</option>
                                        <Option value="items/helms/DeathHelm.swf-DeathHelm">DEAFknight Helm</option>
                                        <Option value="items/helms/cute1.swf-Cute1">Deathdoll enchant</option>
                                        <Option value="items/helms/Scubahelm1.swf-Scubahelm1">Deep Diver Helmet</option>
                                        <Option value="items/helms/pactogonal3.swf-helmpactogonal3">Defender's Winged Armet</option>
                                        <Option value="items/helms/DesHelm.swf-DesHelm">Des Helm</option>
                                        <Option value="items/helms/Dickenshat.swf-Dickenshat">Dicken's Pauper Hat</option>
                                        <Option value="items/helms/DoomBringerSkull.swf-DoomBringerSkull">DoomBringer Skull</option>
                                        <Option value="items/helms/SepulchureCowl.swf-SepulchureCowl">DoomKnight Hood</option>
                                        <Option value="items/helms/DorothyMask.swf-DorothyMask">Dorothy Mask</option>
                                        <Option value="items/helms/Dragonlordcustom.swf-Dragonlordcustom">Dragonlord's Helmet</option>
                                        <Option value="items/helms/Dragonslayer.swf-DragonslayerFHair">Dragonslayer Helm</option>
                                        <Option value="items/helms/Draconushelm1.swf-Draconushelm1">Drakonus Helm</option>
                                        <Option value="items/helms/drowhelm1.swf-drowhelm1">Drow Assassin Cowl</option>
                                        <Option value="items/helms/EfreetFace1.swf-EfreetFace1">Efreet Face</option>
                                        <Option value="items/helms/EfreetHair1.swf-EfreetHair1">Efreet Hair</option>
                                        <Option value="items/helms/Drowface3.swf-Drowface3">Elegant Drow Morph</option>
                                        <Option value="items/helms/SkyGuardHatFemale.swf-SkyGuardHatFemale">Elegant Skyguard Hat</option>
                                        <Option value="items/helms/EliteShadowGuard.swf-EliteShadowGuard">Elite Shadow Guard</option>
                                        <Option value="items/helms/EthanCrown.swf-EthanCrown">Ethan's Crown</option>
                                        <Option value="items/helms/WheelMJPEvilHelm1.swf-WheelMJPEvilHelm1">Evil Iron Wing 1</option>
                                        <Option value="items/helms/WheelMJPEvilHelm2.swf-WheelMJPEvilHelm2">Evil Iron Wing 2</option>
                                        <Option value="items/helms/NewBerzerkerBunnyHelm_r1.swf-NewBerzerkerBunyyHelm3">Evolved Bunny Berserker Helm</option>
                                        <Option value="items/helms/ClawSAHelmNoBeard.swf-ClawSAHelmNoBeard">Evolved Clawshelm</option>
                                        <Option value="items/helms/SolarfluxhelmMiltonius.swf-SolarfluxhelmMiltonius">Evolved Solarflux Helm</option>
                                        <Option value="items/helms/ExoSkinHelm.swf-ExoSkinHelm">ExoSkin Helm</option>
                                        <Option value="items/helms/guardhelm02.swf-guardhelm02">Falcon Hood</option>
                                        <Option value="items/helms/Drowface2.swf-Drowface2">Fauxhawk Drow Morph</option>
                                        <Option value="items/helms/FearFearHelm.swf-FearFearHelm">Fear's Head</option>
                                        <Option value="items/helms/DageScareCrowHelm.swf-DageScareCrowHelm">Field Guardian Hat</option>
                                        <Option value="items/helms/MiltonPoolHelm3.swf-MiltonPoolHelm3">Fiend Face of Miltonius Beta</option>
                                        <Option value="items/helms/MiltonPoolFiend1.swf-MiltonPoolFiend1">Fiend Guard Of Miltonius</option>
                                        <Option value="items/helms/pumpkin3.swf-Pumpkin3">Fiery Jack-O Face</option>
                                        <Option value="items/helms/helm1.swf-Helm1">Fighter Helm</option>
                                        <Option value="items/helms/boneheadfish.swf-boneheadfish">Fishbone Head</option>
                                        <Option value="items/helms/WraithHead3.swf-WraithHead3">Floating Skull</option>
                                        <Option value="items/helms/FormalMageHood.swf-FormalMageHood">Formal Mage Cowl</option>
                                        <Option value="items/helms/FormalWarriorHat.swf-FormalWarriorHat">Formal Void Helm</option>
                                        <Option value="items/helms/Franken1.swf-Franken1">Frankenstein Curse</option>
                                        <Option value="items/helms/draconianhead2.swf-draconianhead2">Frost Drake Morph</option>
                                        <Option value="items/helms/frosthelm01.swf-frosthelm01">Frost Guard</option>
                                        <Option value="items/helms/FrostkingCrown.swf-FrostkingCrown">Frost King Crown</option>
                                        <Option value="items/helms/GarthMaulMask2.swf-GarthMaulMask2">Garth Maul Mask and Hat</option>
                                        <Option value="items/helms/GarthMaulMask.swf-GarthMaulMask">Garth Maul Mask</option>
                                        <Option value="items/helms/GarthMaulMask3.swf-GarthMaulMask3">Garth's Hat and Hair</option>
                                        <Option value="items/helms/GateKeeperHelm.swf-GateKeeperHelm">Gate Keeper Cowl</option>
                                        <Option value="items/helms/GatorguyHead.swf-GatorguyHead">Gatorguy Hood</option>
                                        <Option value="Items/helms/hoodghost1.swf-Hoodghost1">Ghost's Hood</option>
                                        <Option value="items/helms/GoldSilverAssassinHood.swf-GoldSilverAssassinHood">Gilded Assassin's Hood</option>
                                        <Option value="items/helms/SkyGuardHelm.swf-SkyGuardHelm">Gilded Skyguard Helm</option>
                                        <Option value="items/helms/Santahelm01.swf-Santahelm01">Girly Santa Hat</option>
                                        <Option value="items/helms/Frozenhelm1.swf-Frozenhelm1">Glacial Guard</option>
                                        <Option value="items/helms/goldenplatehelm.swf-GoldenPlateHelm">Golden Helm</option>
                                        <Option value="items/helms/GoldenMoglin2Helm.swf-GoldenMoglin2Helm">Golden Moglin Brawler Morph</option>
                                        <Option value="items/helms/GoldenMoglinHelm.swf-GoldenMoglinHelm">Golden Moglin Morph</option>
                                        <Option value="items/helms/GoldenPhoenixHelm1.swf-GoldenPhoenixHelm1">Golden Phoenix Helm</option>
                                        <Option value="items/helms/WheelMJPGoodHelm1.swf-WheelMJPGoodHelm1">Good Iron Wing 1</option>
                                        <Option value="items/helms/WheelMJPGoodHelm2.swf-WheelMJPGoodHelm2">Good Iron Wing 2</option>
                                        <Option value="items/helms/GothikaMaskF.swf-GothikaMaskF">Gothika Mask</option>
                                        <Option value="items/helms/grandhelm1.swf-grandhelm1">Grand Inquisitor Helm</option>
                                        <Option value="items/helms/Pumpkin6.swf-Pumpkin6">Great Pumpkin King's Head</option>
                                        <Option value="items/helms/LycanEars01.swf-LycanEars01">Groomed Lycan Mane</option>
                                        <Option value="items/helms/GroundhogHelm02.swf-GroundhogHelm02">GroundHog Hat</option>
                                        <Option value="items/helms/HappyPandaHelm.swf-HappyPandaHelm">Happy Fat Panda Morph</option>
                                        <Option value="items/helms/Hoodpriest2.swf-Hoodpriest2">Healer's Cowl</option>
                                        <Option value="items/helms/KahliHelmMale.swf-KahliHelmMale">Helm Of Higher Power</option>
                                        <Option value="items/helms/Darklord1.swf-Darklord1">Helm of the Dark Lord</option>
                                        <Option value="items/helms/CNYDragonHelm.swf-CNYDragonHelm">Helm of the Dragon Dance</option>
                                        <Option value="items/helms/GourdianHelm.swf-GourdianHelm">Helm of the Gourdian</option>
                                        <Option value="items/helms/GiftboxhelmMEM.swf-GiftboxhelmMEM">Helm Shaped Giftbox</option>
                                        <Option value="items/helms/HScowlFemale.swf-HScowlfemale">Hero's Female Cowl</option>
                                        <Option value="items/helms/HScowlmale.swf-HScowlmale">Hero's Male Cowl</option>
                                        <Option value="items/helms/MiltonPoolHex1.swf-MiltonPoolHex1">Hex Guard of Miltonius</option>
                                        <Option value="items/helms/grim3.swf-Grim3">High Templar's Hood</option>
                                        <Option value="items/helms/Goodknight1.swf-Goodknight1">Highborn Guard</option>
                                        <Option value="items/helms/hockey1.swf-hockey1">Hockey Mask</option>
                                        <Option value="items/helms/GhostlyHelm.swf-GhostlyHelm">Hollow Head</option>
                                        <Option value="items/helms/HollowZerkerHelm.swf-HollowZerkerHelm">Hollow Zerker Helmet</option>
                                        <Option value="items/helms/HollowsoulHelm.swf-HollowsoulHelm">Hollowsoul Helm</option>
                                        <Option value="items/helms/MiltonPoolHood1.swf-MiltonPoolHood1">Hood of Miltonius</option>
                                        <Option value="items/helms/hoodshadows.swf-hoodshadows">Hood of Shadows</option>
                                        <Option value="items/helms/DayDead4.swf-DayDead4">Hooded Dead Head</option>
                                        <Option value="items/helms/HoodedLegionHelm.swf-HoodedLegionHelm">Hooded Legion Cowl</option>
                                        <Option value="items/helms/Twin1FaceFireMiltonPool.swf-Twin1FaceFireMiltonPool">Hot Head</option>
                                        <Option value="items/helms/hydrahelm1.swf-hydrahelm1">Hydra Battle Helm</option>
                                        <Option value="items/helms/IcecreamHelm.swf-IcecreamHelm">Ice Cream Head</option>
                                        <Option value="items/helms/VampLordHelm.swf-VampLordHelm">Incubus Head Morph</option>
                                        <Option value="items/helms/HockeyMaskFullHair.swf-HockeyMaskFullHair">Intact Hockey Mask</option>
                                        <Option value="items/helms/IronBatHelm.swf-IronBatHelm">Iron Bat Helm</option>
                                        <Option value="items/helms/knight4.swf-Knight4">Iron Head Helm</option>
                                        <Option value="items/helms/J6MechHead.swf-J6MechHead">J6 Gunslinger Helm</option>
                                        <Option value="items/helms/J6.swf-J6helm">J6 Helm</option>
                                        <Option value="items/helms/j6knighthelm.swf-J6KnightHelm">J6 Knight Helm</option>
                                        <Option value="items/helms/j6samuraihelm.swf-J6SamuraiHelm">J6 Samurai Helm</option>
                                        <Option value="items/helms/J6BirthdayHelm.swf-J6BirthdayHelm">J6's Birthday Helm</option>
                                        <Option value="items/helms/jester1a.swf-jester1a">Jester Madhat</option>
                                        <Option value="items/helms/JuniorHat.swf-JuniorHat">Junior's Hat</option>
                                        <Option value="items/helms/HeroHoodBitingDagger.swf-HeroHoodBitingDagger">Knife-biter Helm</option>
                                        <Option value="items/helms/koihelm.swf-koihelm">Koi's Helm</option>
                                        <Option value="items/helms/KoseHood.swf-KoseHood">Kosefira's Hood</option>
                                        <Option value="items/helms/Lampshade1.swf-Lampshade1">Lamp Shade</option>
                                        <Option value="items/helms/LavamancerHelm.swf-LavamancerHelm">Lavamancer Helm</option>
                                        <Option value="items/helms/Ledgehead1.swf-Ledgehead1">Ledgermayne's Helm</option>
                                        <Option value="items/helms/LegionSkull.swf-LegionSkull">Legion Skull</option>
                                        <Option value="items/helms/LeprechaunHatF.swf-LeprechaunHatF">Leprechaun Hat(female)</option>
                                        <Option value="items/helms/LeprechaunHatM.swf-LeprechaunHatM">Leprechaun Hat(male)</option>
                                        <Option value="items/helms/Libertyhelm1.swf-Libertyhelm1">Liberty Helm</option>
                                        <Option value="items/helms/LichHelm1.swf-LichHelm1">Lich Crown</option>
                                        <Option value="items/helms/LightBugHelm.swf-LightBugHelm">Light Bug Visor</option>
                                        <Option value="items/helms/LilahHair.swf-LilahHair">Lilah Hair</option>
                                        <Option value="items/helms/LimHair.swf-LimHair">Lim Lookalike</option>
                                        <Option value="items/helms/LoveHat.swf-LoveHat">Love Hat</option>
                                        <Option value="items/helms/LycanHead.swf-LycanHead">Lycan Head Morph</option>
                                        <Option value="items/helms/hockey2.swf-Hockey2">Mad Crush</option>
                                        <Option value="items/helms/AK1Turban.swf-AK1Turban">Malani Warrior Turban</option>
                                        <Option value="items/helms/feline1.swf-feline1">Male Lion Morph</option>
                                        <Option value="items/helms/Afro01.swf-Afro01">Manly Disco Doo</option>
                                        <Option value="items/helms/HeroHoodAndMask.swf-HeroHoodAndMask">Masked Repo Agent Hood</option>
                                        <Option value="items/helms/Medusa1.swf-Medusa1">Medusa Curse</option>
                                        <Option value="items/helms/MiltonPoolHood3.swf-MiltonPoolHood3">Miltonius' Hood</option>
                                        <Option value="items/helms/jester1.swf-jester1">Mistletoe Madcap</option>
                                        <Option value="items/helms/jester2.swf-jester2">Mistletoe Modestcap</option>
                                        <Option value="items/helms/MoonHelm.swf-MoonHelm">Moonhead</option>
                                        <Option value="items/helms/MountaineerHood.swf-MountaineerHood">Mountaineer's Hood</option>
                                        <Option value="items/helms/MummyHead.swf-MummyHead">Mummy Mask</option>
                                        <Option value="items/helms/MusicalPirateAccessories.swf-MusicalPirateAccessories">Music Pirate Accessories</option>
                                        <Option value="items/helms/hood1.swf-Hood1">Mysterious Hood</option>
                                        <Option value="items/helms/Mysticmagehelm1.swf-Mysticmagehelm1">Mystic Mage Helm</option>
                                        <Option value="items/helms/indian01.swf-Indian01">Native Chief Hat</option>
                                        <Option value="items/helms/indian02.swf-Indian02">Native Feathered hat</option>
                                        <Option value="items/helms/NazgulHelm1.swf-NazgulHelm1">Nazgul Helm</option>
                                        <Option value="items/helms/NecroAltHelm.swf-NecroAltHelm">Necrolock Hood</option>
                                        <Option value="items/helms/NecroHelm.swf-NecroHelm">Necrotic Deathday Helm</option>
                                        <Option value="items/helms/EnglandClam.swf-EnglandClam">New England Clam</option>
                                        <Option value="items/helms/BlackKnighthelm3.swf-BlackKnighthelm3">Nightmare Helm</option>
                                        <Option value="items/helms/NightShockHelmet.swf-NightShockHelmet">Nightshock Helmet</option>
                                        <Option value="items/helms/NOTrutoFace.swf-NOTrutoFace">NOTruto Hair</option>
                                        <Option value="items/helms/MiltonNulgathHorns.swf-MiltonNulgathHorns">Nulgath Horns</option>
                                        <Option value="items/helms/NytheraHair.swf-NytheraHair">Nythera's Hair</option>
                                        <Option value="items/helms/doom_Seppy_original2.swf-doom_Seppy_original2">Onyx Doomknight Helm</option>
                                        <Option value="items/helms/SepulchureCowl3.swf-SepulchureCowl3">Onyx DoomKnight Hood</option>
                                        <Option value="items/helms/UndeadLegionOpenHelm.swf-UndeadLegionOpenHelm">Open Undead Legion Helm</option>
                                        <Option value="items/helms/SepulchureCowl2.swf-SepulchureCowl2">Ornate DoomKnight Hood</option>
                                        <Option value="items/helms/Knight5.swf-Knight5">Paladin's Benediction</option>
                                        <Option value="items/helms/bag1.swf-Bag1">Paper Bag</option>
                                        <Option value="items/helms/pilgrimhat1.swf-Pilgrimhat1">Pilgrim Hat</option>
                                        <Option value="items/helms/Snugbear1F.swf-Snugbear1F">Pink Snug Helm</option>
                                        <Option value="items/helms/Pirate3.swf-Pirate3">Pirate Bandana 3</option>
                                        <Option value="items/helms/PirateCaptainhat1.swf-PirateCaptainhat1">Pirate Captain's Elegant Hat</option>
                                        <Option value="items/helms/Piratehat3.swf-Piratehat3">Pirate Hat 3</option>
                                        <Option value="items/helms/PoliFullHelm.swf-PoliFullHelm">Polistar Full Helm</option>
                                        <Option value="items/helms/PoodleDoo.swf-PoodleDoo">Poodle Doo</option>
                                        <Option value="items/helms/toilethelm.swf-toilethelm">Port-A-Pwnzor Helm</option>
                                        <Option value="items/helms/Composer2Helm.swf-Composer2Helm">Prismatic Composers Helmet</option>
                                        <Option value="items/helms/draconianheadCC.swf-draconianheadCC">Prismatic Draconian Head</option>
                                        <Option value="items/helms/KaratePrism.swf-KaratePrismHelm">Prismatic Gi Mask</option>
                                        <Option value="items/helms/WizardHelmCCFemale.swf-WizardHelmCCFemale">Prismatic Witch Hat</option>
                                        <Option value="items/helms/PrometheusHelm.swf-PrometheusHelm">Prometheus Helm</option>
                                        <Option value="items/helms/Pumpkin7.swf-Pumpkin7">Pumpkin Deviant Helmet</option>
                                        <Option value="items/helms/crown3.swf-Crown3">Queen Tryal's Crown</option>
                                        <Option value="items/helms/randorhood.swf-Randorhood">Randor's Hood</option>
                                        <Option value="items/helms/rangerhat.swf-RangerHat">Ranger Hat</option>
                                        <Option value="items/helms/doom_Seppy_original.swf-doom_Seppy_original">Red DoomKnight Helm</option>
                                        <Option value="items/helms/MaleFooDogHelm.swf-MaleFooDogHelm">Red FooDog Morph</option>
                                        <Option value="items/helms/Hoodredriding1.swf-Hoodredriding1">Red Hunting Hood Helmet</option>
                                        <Option value="items/helms/reaver1.swf-Reaver1">Renegade Mask</option>
                                        <Option value="items/helms/roboorc.swf-roboorc">Roboorc</option>
                                        <Option value="items/helms/RottingPumpkin.swf-RottingPumpkin">Rotting Mogloween Pumpkin</option>
                                        <Option value="items/helms/crown.swf-Crown">Royal Crown</option>
                                        <Option value="items/helms/ZombieTornUpHatMale.swf-ZombieTornUpHatMale">Ruined Zombie Top Hat</option>
                                        <Option value="items/helms/RyokoFace.swf-RyokoFace">Ryoku Hair</option>
                                        <Option value="items/helms/SamuraiHelm1.swf-SamuraiHelm1">Samurai Helmet</option>
                                        <Option value="items/helms/SandWrap.swf-SandWrap">Sandsea Wrap</option>
                                        <Option value="items/helms/Santahelm02.swf-Santahelm02">Santa Claws' Battle Helm</option>
                                        <Option value="items/helms/SantaGirl.swf-SantaGirl">Santa Cutie</option>
                                        <Option value="items/helms/SantaGuy.swf-SantaGuy">Santa Hunk</option>
                                        <Option value="items/helms/ClawsMoglinHelm.swf-ClawsMoglinHelm">Santy Claws Moglin Morph</option>
                                        <Option value="items/helms/rabbit2.swf-rabbit2">Savage Hare Morph</option>
                                        <Option value="items/helms/ScarfBoy.swf-ScarfBoy">Scarfed Boy</option>
                                        <Option value="items/helms/ScarfGirl.swf-ScarfGirl">Scarfed Girly</option>
                                        <Option value="items/helms/SeaweedHat.swf-SeaweedHat">Seaweed Hat</option>
                                        <Option value="items/helms/SekHelm1.swf-SekHelm1">Sek-Duat Mask</option>
                                        <Option value="items/helms/Doom.swf-Doom">Sepulchre's Helmet</option>
                                        <Option value="items/helms/Sequinhat.swf-Sequinhat">Sequined New Year's Hat</option>
                                        <Option value="items/helms/ShadowBreatherMaskMale.swf-ShadowBreatherMaskMale">Shadow Breather mask</option>
                                        <Option value="items/helms/ShadowNinja2.swf-ShadowNinja2">Shadow Cowl</option>
                                        <Option value="items/helms/darkcreeperhead.swf-Darkcreeperhead">Shadow Creeper Enchant</option>
                                        <Option value="items/helms/MiltonPoolShadow1.swf-MiltonPoolShadow1">Shadow Guard Of Miltonius</option>
                                        <Option value="items/helms/ShadowNinja1.swf-ShadowNinja1">Shadow Shinobi Hood</option>
                                        <Option value="items/helms/Vslayer1.swf-Vslayer1">Shadow Z Hat</option>
                                        <Option value="items/helms/MiltonPoolHelm2.swf-MiltonPoolHelm2">Shifter Helm of Miltonius</option>
                                        <Option value="items/helms/SandArmor2Hat.swf-SandArmor2Hat">Shroud of the Sandsea Assassin</option>
                                        <Option value="items/helms/SilverGunsmithHelm.swf-SilverGunsmithHelm">Silver Gunsmith Helm</option>
                                        <Option value="items/helms/J6Sketchhelm.swf-J6Sketchhelm">Sketchy J6 Helm</option>
                                        <Option value="items/helms/Mech2.swf-Mech2">Skull Crusher Helm</option>
                                        <Option value="items/helms/skullhead3.swf-Skullhead3">Skull of Darkness</option>
                                        <Option value="items/helms/MiltonPoolHood2.swf-MiltonPoolHood2">Skull of Miltonius </option>
                                        <Option value="items/helms/SkyGuardHat.swf-SkyGuardHat">Skyguard Captain Hat</option>
                                        <Option value="items/helms/SkyGuardHelm4.swf-SkyGuardHelm4">Skyguard Commander Helm</option>
                                        <Option value="items/helms/SkyGuardHelm2.swf-SkyGuardHelm2">Skyguard Full Helm</option>
                                        <Option value="items/helms/SkyGuardHelm3.swf-SkyGuardHelm3">Skyguard Officer Helm</option>
                                        <Option value="items/helms/Gradhat1.swf-Gradhat1">Smarty Pants Hat</option>
                                        <Option value="items/helms/Sneevilpilot1.swf-Sneevilpilot1">Sneevil Head Pilot</option>
                                        <Option value="items/helms/SnowmanHelm.swf-SnowmanHelm">Snow Head</option>
                                        <Option value="items/helms/snowmanhead1.swf-snowmanhead1">Snowman Head</option>
                                        <Option value="items/helms/GreyHoundHelm.swf-GreyHoundHelm">Solid Metal Head Gear</option>
                                        <Option value="items/helms/footballhelm1.swf-footballhelm1">Spiked Grid Iron Death Helm</option>
                                        <Option value="items/helms/Spiritwolfhair.swf-Spiritwolfhair">Spirit Wolf Hair</option>
                                        <Option value="items/helms/Starsteel.swf-HelmStarsteel">Starsteel Helm</option>
                                        <Option value="items/helms/PaladinStoneHelm.swf-PaladinStoneHelm">Stone Paladin Helm</option>
                                        <Option value="items/helms/GogglesStratosMdown.swf-GogglesStratosMdown">Stratos' Goggles</option>
                                        <Option value="items/helms/Twin1FaceSunMiltonPool.swf-Twin1FaceSunMiltonPool">Sun Head</option>
                                        <Option value="items/helms/TacoAdmiralFemale.swf-TacoAdmiralFemale">Taco Admiral (Female)</option>
                                        <Option value="items/helms/crown5.swf-Crown5">Tainted Crown of Shadow</option>
                                        <Option value="items/helms/TurDHelm.swf-TurDHelm">The Fowl Cowl</option>
                                        <Option value="items/helms/Pancake4.swf-Pancake4">The Full Stack</option>
                                        <Option value="items/helms/RaHelm.swf-RaHelm">The Helmet of Ra</option>
                                        <Option value="items/helms/berserker.swf-berserker">The Master's Hat</option>
                                        <Option value="items/helms/CheeseHelmMale.swf-CheeseHelmMale">The Muenster Master</option>
                                        <Option value="items/helms/WhiteWitchWarlockfemale.swf-WhiteWitchWarlockfemale">The White Witch's Hat</option>
                                        <Option value="items/helms/badgerhat.swf-badgerhat">Thirteen1 Badger Helm</option>
                                        <Option value="items/helms/thyton.swf-Thytonhelm">Thyton's Helm</option>
                                        <Option value="items/helms/tiara.swf-Tiara">Tiara</option>
                                        <Option value="items/helms/Tomixhead.swf-Tomixhead">Tomix's Head</option>
                                        <Option value="items/helms/top.swf-Top">Top Hat</option>
                                        <Option value="items/helms/rabbitberzerker1.swf-rabbitberzerker1">Transforming Berserker Bunny Helm</option>
                                        <Option value="items/helms/TRainbow.swf-TRainbow">Triple Rainbows</option>
                                        <Option value="items/helms/Turdrakenhunter1.swf-Turdrakenhunter1">Turdraken Hunter Hat</option>
                                        <Option value="items/helms/UltimateVictoryHelm.swf-UltimateVictoryHelm">Ultimate Victory Armet</option>
                                        <Option value="items/helms/Ultrahat.swf-Ultrahat">ULTRAHAT</option>
                                        <Option value="items/helms/UndeadLegionUltimateJudge.swf-UndeadLegionUltimateJudge">Undead Legion Judge Helm</option>
                                        <Option value="items/helms/WheelMiltonPoolFace1.swf-WheelMiltonPoolFace1">Unidentified 18 (Dark Cyclops Face)</option>
                                        <Option value="items/helms/paladin2.swf-Paladin2">Valkyrie Wings of Destiny </option>
                                        <Option value="items/helms/paladin1.swf-Paladin1">Valkyrie Wings of Destiny</option>
                                        <Option value="items/helms/Vathhair1.swf-Vathhair1">Vath's Hair</option>
                                        <Option value="items/helms/MiltonPoolHelm1.swf-MiltonPoolHelm1">Vestige of Miltonius</option>
                                        <Option value="items/helms/VileVultureHead.swf-VileVultureHead">Vile Vulture Head</option>
                                        <Option value="items/helms/Voltairehat.swf-Voltairehat">Voltaire Hat and Facial Hair</option>
                                        <Option value="items/helms/Voltairehat2.swf-Voltairehat2">Voltaire Hat</option>
                                        <Option value="items/helms/Warlicface1.swf-Warlicface1">Warlic's Face</option>
                                        <Option value="items/helms/dread1.swf-Dread1">Warlord of Destruction</option>
                                        <Option value="items/helms/WFhelm.swf-WFhelm">WarpForce Heavygunner Helm</option>
                                        <Option value="items/helms/ViciousRabbitHelm2011.swf-ViciousRabbitHelm2011">Warrior of the Rabbit Helm</option>
                                        <Option value="items/helms/WerePyreSlayerHelm.swf-WerePyreSlayerHelm">Werepyre Slayer Helm</option>
                                        <Option value="items/helms/SunGlasses2.swf-SunGlasses2">Wild Shades</option>
                                        <Option value="items/helms/WyrmHair1.swf-WyrmHair1">Wyrm's Hair</option>
                                        <Option value="items/helms/2011RabitHelm.swf-2011RabbitHelm">Year of the Rabbit Morph</option>
                                        <Option value="items/helms/Pumpkin5.swf-Pumpkin5">Young Pumpkin Head</option>
                                        <Option value="items/helms/ZazulFace.swf-ZazulFace">Zazul's Face</option>
                                        <Option value="items/helms/XboxBattlehelm1.swf-XboxBattlehelm1">Zeke Battle Helm</option>
                                        <Option value="items/helms/BTAMasteZhilo.swf-BTAMasteZhilo">Zhilo Hairstyle</option>
                                        <Option value="items/helms/ZombieNormalMale.swf-ZombieNormalMale">Zombie Top Hat (male)</option>
                                        <Option value="items/helms/SteamGearHelm.swf-SteamGearHelm">SteamGear Hat</option>
                                        <Option value="items/helms/OmegaAlchemistMMask.swf-OmegaAlchemistMMask">Omega Alchemist Male</option>
                                        <Option value="items/helms/OmegaAlchemistFMask.swf-OmegaAlchemistFMask">Omega Alchemist Female</option>
                                        <Option value="items/helms/MechDHelm.swf-MechDHelm">Mecha Defender</option>
                                        <Option value="items/helms/BeretMaskM.swf-BeretMaskM">Male Beret and Mask</option>
                                        <Option value="items/helms/BeretM.swf-BeretM">Male Beret</option>
                                        <Option value="items/helms/InfiltratorMask.swf-InfiltratorMask">Infiltrator Mask</option>
                                        <Option value="items/helms/HunterMask.swf-HunterMask">Hunter Mask</option>
                                        <Option value="items/helms/BeretMaskF.swf-BeretMaskF">Female Beret and Mask</option>
                                        <Option value="items/helms/BeretF.swf-BeretF">Female Beret</option>
                                        <Option value="items/helms/DeathDealerPigTailsMask.swf-DeathDealerPigTailsMask">DeathDealer Pigtails</option>
                                        <Option value="items/helms/DeathDealerFauxHawkMask.swf-DeathDealerFauxHawkMask">DeathDealer FauxHawk</option>
                                        <Option value="items/helms/OPallyHelm.swf-OPallyHelm">Aurus Via Helm</option>
                                        <Option value="items/helms/AssaultMask.swf-AssaultMask">Assault Mask</option>
                                        <Option value="items/helms/MaskandHairM.swf-MaskandHairM">Aerosol Protector Male</option>
                                        <Option value="items/helms/MaskandHairF.swf-MaskandHairF">Aerosol Protector Female</option>
                                        <Option value="items/helms/ShadowBornMask.swf-ShadowBornMask">Shadow Born Mask</option>
                                        <Option value="items/helms/SkeleCaptainHelm.swf-SkeleCaptainHelm">SkeleCommander's Helm</option>
                                        <Option value="items/helms/TeslaMageHood.swf-TeslaMageHood">Techno Hood</option>
                                        <Option value="items/helms/LakensHelm.swf-LakensHelm">Laken's Formal Visor</option>
                                        <Option value="items/helms/RageHelm.swf-RageHelm">Rage Armet</option>
                                        <Option value="items/helms/MadSciHelm5.swf-MadSciHelm5">Toxic Vision Helm</option>
                                        <Option value="items/helms/UltimateVictoryHelmMale.swf-UltimateVictoryHelmMale">Helm of Ultimate Victory</option>
                                        <Option value="items/helms/Halftophat.swf-Halftophat">Halfpipe Top Hat</option>
                                        <Option value="items/helms/UndeadTitanHood.swf-UndeadTitanHood">Soul Harvester Hood</option>
                                    </SELECT><td>
                            </tr>
                            <tr>
                                <td><b><img src="images/pet.png" width="15px" /> Pet:</b></td>
                                <td style="display:none;"><input onChange="javascript:ChangeItem('pet')" type="text" name="hairfile" value="<?php echo $cpfile; ?>"></td>
                                <td style="display:none;"><input onChange="javascript:ChangeItem('pet')" type="text" name="hairlink" value="<?php echo $cplink; ?>"></td>
                                <td style="display:none;"><input onChange="javascript:ChangeItem('pet')" type="text" name="hairname" value="<?php echo $cpname; ?>"></td>
                                <td><select id="pet" onChange="javascript:ChangeItem('pet')" NAME="PetSelect">
                                        <Option value="items/pets/ArmoredDaimyo.swf~ArmoredDaimyo">Armored Daimyo</option>
                                        <Option value="">None</option>
                                        <Option value="items/pets/MiltonPoolBetrayalBATTLE1.swf~MiltonPoolBetrayalBATTLE1">1st Betrayal Blade of Nulgath</option>
                                        <Option value="items/pets/MiltonPoolBetrayalBATTLE2.swf~MiltonPoolBetrayalBATTLE2">2nd Betrayal Blade of Nulgath</option>
                                        <Option value="items/pets/MiltonPoolBetrayalBATTLE3.swf~MiltonPoolBetrayalBATTLE3">3rd Betrayal Blade of Nulgath</option>
                                        <Option value="items/pets/MiltonPoolBetrayalBATTLE4.swf~MiltonPoolBetrayalBATTLE4">4th Betrayal Blade of Nulgath</option>
                                        <Option value="items/pets/MiltonPoolBetrayalBATTLE5.swf~MiltonPoolBetrayalBATTLE5">5th Betrayal Blade of Nulgath</option>
                                        <Option value="items/pets/MiltonPoolBetrayalBATTLE6.swf~MiltonPoolBetrayalBATTLE6">6th Betrayal Blade of Nulgath</option>
                                        <Option value="items/pets/MiltonPoolBetrayalBATTLE7.swf~MiltonPoolBetrayalBATTLE7">7th Betrayal Blade of Nulgath</option>
                                        <Option value="items/pets/Grenwogpet3.swf~Grenwogpet3">Albino Onyx Armored Grenwog</option>
                                        <Option value="items/pets/MiltonPoolOrb1_2Aug10.swf~MiltonPoolOrb1">Arcane Orb</option>
                                        <Option value="items/pets/Arcanewolf.swf~Arcanewolf">Arcane Wolf</option>
                                        <Option value="items/pets/babydrgonarmoredfounder.swf~Babydragonarmoredfounder">Armored Baby Frost Dragon 08</option>
                                        <Option value="items/pets/Babydragonarmoredfrostdragon.swf~Babydragonarmoredfrostdragon">Armored Baby Frost Dragon</option>
                                        <Option value="items/pets/ChickencalfArnored.swf~ChickencalfArnored">Armored Chickcalf</option>
                                        <Option value="items/pets/chinesedragon.swf~chinesedragon">Asian Dragon</option>
                                        <Option value="items/pets/babydragonFrost2009.swf~babydragonFrost2009">Baby Frost Drake</option>
                                        <Option value="items/pets/babydragon.swf~PetDragon">Baby Red Dragon</option>
                                        <Option value="items/pets/babydragondark.swf~babydragondark">Baby Shadow Dragon</option>
                                        <Option value="items/pets/kittenblack2.swf~kittenblack2">Bad Luck Kitten</option>
                                        <Option value="items/pets/santabeetle.swf~santabeetle">Bah-hum Bug</option>
                                        <Option value="items/pets/BaldEagel1.swf~BaldEagel1">Bald Eagle</option>
                                        <Option value="items/pets/Balloonbeleenpet.swf~Balloonbeleenpet">Beleen Balloon</option>
                                        <Option value="items/pets/DerpFish.swf~DerpFish">Beleen's Stupid Derp-Fish</option>
                                        <Option value="items/pets/BigDaddy.swf~BigDaddy">Big Daddy</option>
                                        <Option value="items/pets/InvaderBlack.swf~InvaderBlack">Black Spaced Intruder</option>
                                        <Option value="items/pets/MiltonPoolOrb2_2Aug10.swf~MiltonPoolOrb2">Blood Orb</option>
                                        <Option value="items/pets/spiderpet05.swf~spiderpet05">Blood Spider</option>
                                        <Option value="items/pets/trobble1.swf~PetTrobble1">Blue Trobble</option>
                                        <Option value="items/pets/BrokenDeady.swf~BrokenDeady">Broken Deady</option>
                                        <Option value="items/pets/wolfric.swf~PetWolfric">Brown Wolf</option>
                                        <Option value="items/pets/moglineaster1.swf~moglineaster1">Cabdury</option>
                                        <Option value="items/pets/Cactusmiltoniuspet.swf~Cactusmiltoniuspet">Cactus Creeper</option>
                                        <Option value="items/pets/candybabydragon.swf~candybabydragon">Candy-Coated Baby Frost Dragon</option>
                                        <Option value="items/pets/FoxPet.swf~FoxPet">Chaos Fox</option>
                                        <Option value="items/pets/Chatterteeth1.swf~Chatterteeth1">Chatter Teeth</option>
                                        <Option value="items/pets/chimerapet.swf~chimerapet">Chimera of Vadriel</option>
                                        <Option value="items/pets/ChinchSyrup.swf~ChinchSyrup">Chinchilla with Syrup</option>
                                        <Option value="items/pets/PetBunnyCNY.swf~PetBunnyCNY">Chinese New Year Rabbit</option>
                                        <Option value="items/pets/bunnychocolate1_r1.swf~bunnychocolate1">Choco-Bunny</option>
                                        <Option value="items/pets/Chinchpet.swf~Chinchpet">Chongo the Chinchilla</option>
                                        <Option value="items/pets/chucklespet2.swf~chucklespet2">Chuckles Skull</option>
                                        <Option value="items/pets/frogzardcoal.swf~coalzard">CoalZard</option>
                                        <Option value="items/pets/MiltonPoolAC1.swf~MiltonPoolAC1">Coin of Miltonius</option>
                                        <Option value="items/pets/ColePet.swf~ColePet">Cole</option>
                                        <Option value="items/pets/CountMogula.swf~CountMogula">Count Mogula</option>
                                        <Option value="items/pets/MiltonPoolCragBamboozle.swf~MiltonPoolCragBamboozle">Crag & Bamboozle</option>
                                        <Option value="items/pets/JellyfishMiltonPoolPet2.swf~JellyfishMiltonPoolPet2">Crystallized Jellyfish</option>
                                        <Option value="items/pets/Ballooncyseropet.swf~Ballooncyseropet">Cysero Balloon</option>
                                        <Option value="items/pets/cake2.swf~cake2">Cysero's Wedding Cake</option>
                                        <Option value="items/pets/daimyo.swf~PetDaimyo">Daimyo</option>
                                        <Option value="items/pets/dark.swf~PetDark">Dark Crystal</option>
                                        <Option value="items/pets/moglindark.swf~moglindark">Dark Moglin</option>
                                        <Option value="items/pets/wolfric3.swf~PetWolfric3">Dark Wolf</option>
                                        <Option value="items/pets/Deady.swf~Deady">Deady the Evil Teddy</option>
                                        <Option value="items/pets/Direwolfpink.swf~Direwolfpink">Direly Adorable Wolf</option>
                                        <Option value="items/pets/MiltonPoolBetrayalBATTLE8.swf~MiltonPoolBetrayalBATTLE8">8th Betrayal Blade of Nulgath</option>
                                        <Option value="items/pets/DogofWar.swf~DogofWar">Dog of War</option>
                                        <Option value="items/pets/babydragonundead.swf~Babydragonundead">Dracolich Baby Dragon</option>
                                        <Option value="items/pets/MiltonPoolSneevil1-18Oct10.swf~MiltonPoolSneevil1">Drudgen the Assistant</option>
                                        <Option value="items/pets/bunnyDust.swf~bunnyDust">Dust Bunny</option>
                                        <Option value="items/pets/Dolphin.swf~Dolphin">Evil Professor Dolfo</option>
                                        <Option value="items/pets/Fenrir.swf~Fenrir">Fenrir</option>
                                        <Option value="items/pets/ferret1.swf~Ferret1">Ferret</option>
                                        <Option value="items/pets/flyingcandycorn.swf~FlyingCandyCorn">Flying Candycorn</option>
                                        <Option value="items/pets/FlyingMonkey.swf~FlyingMonkey">Flying Marmoset</option>
                                        <Option value="items/pets/FlyingSkull.swf~FlyingSkull">Flying Skull</option>
                                        <Option value="items/pets/TigerForest.swf~TigerForest">Forest Tiger</option>
                                        <Option value="items/pets/Freebird.swf~Freebird">Freebird</option>
                                        <Option value="items/pets/beetle01.swf~beetle01">Frost Beetle</option>
                                        <Option value="items/pets/DireWolfwht.swf~Direwolfwht">Full Moon Dire Wolf</option>
                                        <Option value="items/pets/IceMoglinPet.swf~IceMoglinPet">Glacial Moglin</option>
                                        <Option value="items/pets/phoenix1.swf~phoenix1">Golden Phoenix</option>
                                        <Option value="items/pets/GradMoglin.swf~GradMoglin">Graduate Moglin</option>
                                        <Option value="items/pets/Grenwogpet.swf~Grenwogpet">Grenwog</option>
                                        <Option value="items/pets/hawkgray.swf~PetHawkgray">Grey Hawk</option>
                                        <Option value="items/pets/spiderpet01.swf~spiderpet01">Ice Spider Pet</option>
                                        <Option value="items/pets/IronRuneDragon.swf~IronRuneDragon">Iron Rune Dragon</option>
                                        <Option value="items/pets/babydragonballoon.swf~babydragonballoon">Jacon Balloon Dragon</option>
                                        <Option value="items/pets/KreathPet.swf~KreathPet">Kreath's Pet</option>
                                        <Option value="items/pets/landerpet.swf~landerpet">Lunar Lander</option>
                                        <Option value="items/pets/M1000.swf~M1000">M-1000</option>
                                        <Option value="items/pets/mazumi.swf~PetMazumi">Mazumi</option>
                                        <Option value="items/pets/mercGnome.swf~mercGnome">Mercenary Gnome</option>
                                        <Option value="items/pets/DireWolfblk.swf~Direwolfblk">Midnight Dire Wolf</option>
                                        <Option value="items/pets/MiniManaElemental.swf~MiniManaElemental">Mini Mana Elemental</option>
                                        <Option value="items/pets/MiltonPoolMiltonius1.swf~MiltonPoolMiltonius1">Mini Miltonius</option>
                                        <Option value="items/pets/MiniZeke1.swf~MiniZeke1">Mini Zeke</option>
                                        <Option value="items/pets/moglinjester.swf~moglinjester">Moglin Jester</option>
                                        <Option value="items/pets/moglinpatrick2.swf~moglinpatrick2">Moglin Wallace</option>
                                        <Option value="items/pets/FlyingMoglinHead.swf~FlyingMoglinHead">Moglin's Tutelar</option>
                                        <Option value="items/pets/DerpCuppycake.swf~DerpCuppycake">Derpy Cyppycake</option>
                                        <Option value="items/pets/MiltonPoolNulgathLarva.swf~MiltonPoolNulgathLarva">Nulgath Larvae</option>
                                        <Option value="items/pets/nutcracker.swf~nutcracker">Nutcracker</option>
                                        <Option value="items/pets/MiltonPoolOblivionBATTLE1.swf~MiltonPoolOblivionBATTLE1">Oblivion of Nulgath</option>
                                        <Option value="items/pets/oolong.swf~oolong">Oolong</option>
                                        <Option value="items/pets/owl1.swf~Owl1">Owl of Wisdom</option>
                                        <Option value="items/pets/GoldenMoglinPet2.swf~GoldenMoglinPet2">Pair of Golden Moglins</option>
                                        <Option value="items/pets/ZorbakCrasher.swf~ZorbakCrasher">Party Crasher Zorbak</option>
                                        <Option value="items/pets/rainbowrat.swf~RainbowRat">Pet Rainbow Rat</option>
                                        <Option value="items/pets/hellhoundblack.swf~hellhoundblack">Phaedra of DOOM</option>
                                        <Option value="items/pets/hellhound1.swf~hellhound1">Phaedra</option>
                                        <Option value="items/pets/GroundhogPet.swf~GroundhogPet">Philip, the weather predicting groundhog</option>
                                        <Option value="items/pets/PinkChinchPet.swf~PinkChinchPet">Pink Chinchilla</option>
                                        <Option value="items/pets/Chinch16Pink.swf~Chinch16Pink">Pink Retro Chongo</option>
                                        <Option value="items/pets/ChinchPetPinkBlack.swf~ChinchPetPinkBlack">Pink'n Black Chongo</option>
                                        <Option value="items/pets/babydragonfounder.swf~babydragonfounder">Platinum Dragon</option>
                                        <Option value="items/pets/MiltonPoolOrb3_2Aug10.swf~MiltonPoolOrb3">Primal Orb</option>
                                        <Option value="items/pets/PetSpritesCC.swf~PetSpritesCC">Prismatic Sprites</option>
                                        <Option value="items/pets/pumpkinkingpet.swf~Pumpkinkingpet">Pumpkinking Pet</option>
                                        <Option value="items/pets/JellyfishMiltonPoolPet1.swf~JellyfishMiltonPoolPet1">Purple Crystallized Jellyfish</option>
                                        <Option value="items/pets/ReignZard.swf~ReignZard">Randolph the Red Nosed Reinzard</option>
                                        <Option value="items/pets/WindMiltonius.swf~WindMiltonius">Recyclone</option>
                                        <Option value="items/pets/moglinred.swf~PetMoglinred">Red Moglin</option>
                                        <Option value="items/pets/reigndog.swf~reigndog">Reign Doggy</option>
                                        <Option value="items/pets/reigndragon.swf~reigndragon">Reigndragon</option>
                                        <Option value="items/pets/DrillBot.swf~DrillBot">Robotic Drill Bot</option>
                                        <Option value="items/pets/moglinsanta.swf~moglinsanta">Santa Moglin</option>
                                        <Option value="items/pets/sneevil2.swf~sneevil2">Santa Sneevil</option>
                                        <Option value="items/pets/Chomper1.swf~Chomper1">Shadow Chomper</option>
                                        <Option value="items/pets/MiltonPoolOrb4_2Aug10.swf~MiltonPoolOrb4">Shadow Orb</option>
                                        <Option value="items/pets/SinisterPumpkin.swf~SinisterPumpkin">Sinister Pumpkin Pet</option>
                                        <Option value="items/pets/SkullSpiderPet1.swf~SkullSpiderPet1">Skull Spider</option>
                                        <Option value="items/pets/Smartypants.swf~Smartypants">Smartypants Pony</option>
                                        <Option value="items/pets/snowballpet.swf~snowballpet">Snowball</option>
                                        <Option value="items/pets/sockdragon.swf~sockdragon">Sock Dragon</option>
                                        <Option value="items/pets/spiderpet02.swf~spiderpet02">SPIDER NEEDS NAME 2</option>
                                        <Option value="items/pets/spiderpet03.swf~spiderpet03">SPIDER NEEDS NAME 3</option>
                                        <Option value="items/pets/spiderpet04.swf~spiderpet04">SPIDER NEEDS NAME 4</option>
                                        <Option value="items/pets/babydragonchaos.swf~babydragonchaos">Stalagbite</option>
                                        <Option value="items/pets/SteampunkDragon.swf~SteampunkDragon">Steampunk Dragon</option>
                                        <Option value="items/pets/stumpy.swf~stumpy">Stumpy</option>
                                        <Option value="items/pets/MoglinPetPink.swf~MoglinPetPink">Super Adorable Pink Moglin</option>
                                        <Option value="items/pets/MiltonPoolPet1_r1.swf~MiltonPoolPet1">Sword of Miltonius</option>
                                        <Option value="items/pets/MiltonPoolTaroBATTLE1.swf~MiltonPoolTaroBATTLE1">Taro Blademaster Guardian</option>
                                        <Option value="items/pets/ToDo.swf~ToDo">Tododo</option>
                                        <Option value="items/pets/tricicle.swf~tricicle">Tricicle</option>
                                        <Option value="items/pets/moglintwig.swf~Moglintwig">Twig</option>
                                        <Option value="items/pets/Twigenator.swf~Twigenator">Twiginator</option>
                                        <Option value="items/pets/IndianTwig.swf~IndianChiefTwig">Twigwam</option>
                                        <Option value="items/pets/Balloontwillypet.swf~Balloontwillypet">Twilly Balloon</option>
                                        <Option value="items/pets/chickenpet2.swf~chickenpet2">Unhatched Egg</option>
                                        <Option value="items/pets/Voidlarvapet1.swf~Voidlarvapet1">Void Larva</option>
                                        <Option value="items/pets/bunnyeaster1.swf~bunnyeaster1">Vorpal Bunny</option>
                                        <Option value="items/pets/WaldothePigon.swf~WaldothePigon">Waldo the Pigeon - Pigeon w/Monocle</option>
                                        <Option value="items/pets/ChibiWhiteTiger.swf~ChibiWhiteTiger">White Chibi Tiger</option>
                                        <Option value="items/pets/moglinwhite.swf~moglinwhite">White Moglin</option>
                                        <Option value="items/pets/UndeadTurkeyPet.swf~UndeadTurkeyPet">Wishbone Pet</option>
                                        <Option value="items/pets/TheCreature.swf~TheCreature">The Creature</option>
                                    </select><td>
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
                            <option value='6' <?php
                                    if ($_GET['bgindex'] == "6") {
                                        echo"selected='true'";
                                    }
                                    ?>>Shadowfall</option>";
                            <option value='0' <?php
                            if ($_GET['bgindex'] == "0") {
                                echo"selected='true'";
                            }
                            ?>>Battleon</option>";
                            <option value='1' <?php
                            if ($_GET['bgindex'] == "1") {
                                echo"selected='true'";
                            }
                            ?>>DoomWood Forest</option>";
                            <option value='2' <?php
                                    if ($_GET['bgindex'] == "2") {
                                        echo"selected='true'";
                                    }
                                    ?>>Ledgermayne</option>";
                            <option value='3' <?php
                            if ($_GET['bgindex'] == "3") {
                                echo"selected='true'";
                            }
                            ?>>Lightguard Keep</option>";
                            <option value='4' <?php
                            if ($_GET['bgindex'] == "4") {
                                echo"selected='true'";
                            }
                            ?>>Northland Lights</option>";
                            <option value='5' <?php
                                    if ($_GET['bgindex'] == "5") {
                                        echo"selected='true'";
                                    }
                                    ?>>Djinn</option>";
                            <option value='7' <?php
                        if ($_GET['bgindex'] == "7") {
                            echo"selected='true'";
                        }
                        ?>>Skyguard</option>";
                            <option value='8' <?php
                        if ($_GET['bgindex'] == "8") {
                            echo"selected='true'";
                        }
                        ?>>The Void</option>";
                            <option value='9' <?php
                        if ($_GET['bgindex'] == "9") {
                            echo"selected='true'";
                        }
                        ?>>Yulgars' Inn</option>";
                            <option value='A' <?php
                        if ($_GET['bgindex'] == "A") {
                            echo"selected='true'";
                        }
                                    ?>>Mogloween</option>";
                            <option value='B' <?php
                            if ($_GET['bgindex'] == "B") {
                                echo"selected='true'";
                            }
                            ?>>Frostvale</option>";
                            <option value='C' <?php
                            if ($_GET['bgindex'] == "C") {
                                echo"selected='true'";
                            }
                            ?>>Love</option>";
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><b>Character SWF:</b></td>
                    <td>
                        <select onChange="javascript:makecode()" type="text" name="aqwURLS">
                            <option value='5'>v5</option>";
                            <option value='4' selected='true'>v4</option>";
                            <option value='3'>v3</option>";
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><b>Faction:</b></td>
                    <td>
                        <select onChange="javascript:makecode()" type="text" name="aqwURLS">
                            <option value='Good' <?php
                            if ($faction == 'Good') {
                                echo"selected='true'";
                            }
                            ?>>Good</option>";
                            <option value='Evil' <?php
                            if ($faction == "Evil") {
                                echo"selected='true'";
                            }
                            ?>>Evil</option>";
                        </select>
                    </td>
                </tr>
                <td style='display:none;'><input type="text" name="grabbed" value="<?php echo $grabbed; ?>"></td>
                <td style='display:none;'>><input type="text" name="using" value=""></td>
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
        var usingSWF = false;
        document.getElementsByTagName('input')[29].value = "true";
        if (document.getElementsByTagName('input')[28].value == "grabbed") {
            usingSWF = true;
            document.getElementsByTagName('input')[29].value = "true";
            useSWF();
        } else {
            usingSWF = false;
            useDrops();
            document.getElementsByTagName('input')[29].value = "false";
        }
        function d2h(d) {
            return d.toString(16);
        }
        function h2d(h) {
            return parseInt(h, 16);
        }
        function useSWF() {
            document.getElementsByTagName('td')[27].style.display = "";
            document.getElementsByTagName('td')[28].style.display = "";
            document.getElementsByTagName('td')[29].style.display = "";
            document.getElementsByTagName('td')[30].style.display = "none";
            document.getElementsByTagName('td')[31].style.display = "";
            document.getElementsByTagName('td')[32].style.display = "";
            document.getElementsByTagName('td')[33].style.display = "";
            document.getElementsByTagName('td')[34].style.display = "";
            document.getElementsByTagName('td')[35].style.display = "none";
            document.getElementsByTagName('td')[36].style.display = "none";
            document.getElementsByTagName('td')[37].style.display = "";
            document.getElementsByTagName('td')[38].style.display = "";
            document.getElementsByTagName('td')[39].style.display = "";
            document.getElementsByTagName('td')[40].style.display = "";
            document.getElementsByTagName('td')[41].style.display = "none";
            document.getElementsByTagName('td')[42].style.display = "";
            document.getElementsByTagName('td')[43].style.display = "";
            document.getElementsByTagName('td')[44].style.display = "";
            document.getElementsByTagName('td')[45].style.display = "";
            document.getElementsByTagName('td')[46].style.display = "";
            document.getElementsByTagName('td')[47].style.display = "none";
            document.getElementsByTagName('td')[48].style.display = "";
            document.getElementsByTagName('td')[49].style.display = "";
            document.getElementsByTagName('td')[50].style.display = "";
            document.getElementsByTagName('td')[51].style.display = "";
            document.getElementsByTagName('td')[52].style.display = "";
            document.getElementsByTagName('td')[53].style.display = "none";
            usingSWF = true;
            document.getElementsByTagName('input')[29].value = "true";
        }
        function useDrops() {
            usingSWF = false;
            document.getElementsByTagName('input')[29].value = "false";
            document.getElementsByTagName('td')[27].style.display = "none";
            document.getElementsByTagName('td')[28].style.display = "none";
            document.getElementsByTagName('td')[29].style.display = "none";
            document.getElementsByTagName('td')[30].style.display = "";
            document.getElementsByTagName('td')[31].style.display = "";
            document.getElementsByTagName('td')[32].style.display = "none";
            document.getElementsByTagName('td')[33].style.display = "none";
            document.getElementsByTagName('td')[34].style.display = "none";
            document.getElementsByTagName('td')[35].style.display = "";
            document.getElementsByTagName('td')[36].style.display = "";
            document.getElementsByTagName('td')[37].style.display = "";
            document.getElementsByTagName('td')[38].style.display = "none";
            document.getElementsByTagName('td')[39].style.display = "none";
            document.getElementsByTagName('td')[40].style.display = "none";
            document.getElementsByTagName('td')[41].style.display = "";
            document.getElementsByTagName('td')[42].style.display = "";
            document.getElementsByTagName('td')[43].style.display = "";
            document.getElementsByTagName('td')[44].style.display = "none";
            document.getElementsByTagName('td')[45].style.display = "none";
            document.getElementsByTagName('td')[46].style.display = "none";
            document.getElementsByTagName('td')[47].style.display = "";
            document.getElementsByTagName('td')[48].style.display = "none";
            document.getElementsByTagName('td')[49].style.display = "";
            document.getElementsByTagName('td')[50].style.display = "none";
            document.getElementsByTagName('td')[51].style.display = "none";
            document.getElementsByTagName('td')[52].style.display = "none";
            document.getElementsByTagName('td')[53].style.display = "";
        }
        function ChangeItem(itemtype) {
            if (usingSWF == false) {
                if (itemtype == "armor") {
                    document.getElementsByTagName('input')[11].value = document.getElementsByTagName('select')[1].value.split("~")[0];
                    document.getElementsByTagName('input')[12].value = document.getElementsByTagName('select')[1].value.split("~")[1];
                    document.getElementsByTagName('input')[13].value = document.getElementsByTagName('select')[1].options[document.getElementsByTagName('select')[1].selectedIndex].text;
                } else if (itemtype == "helm") {
                    document.getElementsByTagName('input')[20].value = document.getElementsByTagName('select')[5].value.split("-")[0];
                    document.getElementsByTagName('input')[21].value = document.getElementsByTagName('select')[5].value.split("-")[1];
                    document.getElementsByTagName('input')[22].value = document.getElementsByTagName('select')[5].options[document.getElementsByTagName('select')[5].selectedIndex].text;
                } else if (itemtype == "weapon") {
                    document.getElementsByTagName('input')[14].value = document.getElementsByTagName('select')[2].value.split("-")[0];
                    document.getElementsByTagName('input')[15].value = document.getElementsByTagName('select')[2].value.split("-")[1];
                    document.getElementsByTagName('input')[16].value = document.getElementsByTagName('select')[2].options[document.getElementsByTagName('select')[2].selectedIndex].text;
                } else if (itemtype == "cape") {
                    document.getElementsByTagName('input')[17].value = document.getElementsByTagName('select')[4].value.split("-")[0];
                    document.getElementsByTagName('input')[18].value = document.getElementsByTagName('select')[4].value.split("-")[1];
                    document.getElementsByTagName('input')[19].value = document.getElementsByTagName('select')[4].options[document.getElementsByTagName('select')[4].selectedIndex].text;
                } else if (itemtype == "pet") {
                    document.getElementsByTagName('input')[23].value = document.getElementsByTagName('select')[6].value.split("~")[0];
                    document.getElementsByTagName('input')[24].value = document.getElementsByTagName('select')[6].value.split("~")[1];
                    document.getElementsByTagName('input')[25].value = document.getElementsByTagName('select')[6].options[document.getElementsByTagName('select')[6].selectedIndex].text;
                }
            }
            makecode();
        }
        function makecode()
        {
            if (document.getElementsByTagName('select')[8].value == "5") {
                var swfurl = "http://cdn.aqworlds.com/flash/chardetail/character5.swf"
            } else if (document.getElementsByTagName('select')[8].value == "4") {
                var swfurl = "http://cdn.aqworlds.com/flash/chardetail/character4.swf"
            } else if (document.getElementsByTagName('select')[8].value == "3") {
                var swfurl = "http://cdn.aqworlds.com/flash/chardetail/character3.swf"
            } else if (document.getElementsByTagName('select')[8].value == "2") {
                var swfurl = "http://cdn.aqworlds.com/flash/chardetail/character2.swf"
            } else if (document.getElementsByTagName('select')[8].value == "1") {
                var swfurl = "http://cdn.aqworlds.com/flash/chardetail/character.swf"
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
            var weapontype = document.getElementsByTagName('select')[3].value
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
            var background = document.getElementsByTagName('select')[7].value
            var faction = document.getElementsByTagName('select')[9].value
            document.getElementsByTagName('textarea')[0].value = "http://alphafable.info/charbuild/index.php?username=" + name + "&level=" + lvl + "&gender=" + gender + "&class=" + charclass + "&plaColorHair=" + d2h(haircolor) + "&plaColorSkin=" + d2h(skincolor) + "&plaColorEyes=" + d2h(eyecolor) + "&cosColorTrim=" + d2h(trim) + "&cosColorBase=" + d2h(base) + "&cosColorAccessory=" + d2h(accessory) + "&hairswf=" + hair + "&hairlink=" + hairlink + "&armfilename=" + armor + "&armlinkage=" + armorlink + "&wepfilename=" + weapon + "&weplinkage=" + weaponlink + "&helmfilename=" + helm + "&helmlinkage=" + helmlink + "&petfilename=" + pet + "&petlinkage=" + petlink + "&capefilename=" + cape + "&capelinkage=" + capelink + "&strArmorName=" + armname + "&strWeaponType=" + weapontype + "&strWeaponName=" + weaponname + "&strPetName=" + cpname + "&strCapeName=" + baname + "&strHelmName=" + helmname + "&bgindex=" + background + "&ia1=1&strFaction=" + faction;
            var code = '<embed src="' + swfurl + '" width="550" height="350" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" flashvars="intColorHair=' + haircolor + '&intColorSkin=' + skincolor + '&intColorEye=' + eyecolor + '&intColorTrim=' + trim + '&intColorBase=' + base + '&intColorAccessory=' + accessory + '&strGender=' + gender + '&strHairFile=' + hair + '&strHairName=' + hairlink + '&strName=' + name + '&intLevel=' + lvl + '&strClassName=' + charclass + '&strClassFile=' + armor + '&strClassLink=' + armorlink + '&strWeaponFile=' + weapon + '&strWeaponLink=' + weaponlink + '&strCapeFile=' + cape + '&strCapeLink=' + capelink + '&strHelmFile=' + helm + '&strHelmLink=' + helmlink + '&strPetFile=' + pet + '&strPetLink=' + petlink + '&strArmorName=' + armname + '&strWeaponType=' + weapontype + '&strWeaponName=' + weaponname + '&strPetName=' + cpname + '&strCapeName=' + baname + '&strHelmName=' + helmname + '&bgindex=' + background + '&ia1=1&strFaction=' + faction + '"></embed></object>';
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