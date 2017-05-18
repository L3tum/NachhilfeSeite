<?php

/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 04.05.2017
 * Time: 19:01
 */

//Just to note the parameters

class OuterShell{
    //0 integer DATA_FLAG
    //1 array   Data (either message or something else based on flag)
}

class MessageToClient // DATA_FLAG=0
{
    //0 integer BenutzerID des Senders
    //1 String  Die Nachricht
    //2 String  Datum des Versands in dd.mm.YYYY
    //3 String  Zeit des Versands in HH:mm
}
class MessageToServer // DATA_FLAG=1
{
    //0 integer BenutzerID des Senders
    //1 integer BenutzerID des Empfängers
    //2 String  Die Nachricht
}

//On connected
class InformationToClient // DATA_FLAG=2
{
    //0 bool sendInfoPlox
    //1 integer temporaryNumber
}
//Response to InformationToClient
class InformationToServer // DATA_FLAG=3
{
    //0 integer temporaryNumber
    //1 integer BenutzerID
    //2 integer sessionID
}

//In order to figure out if he really is the right user check Session_id
class InformationMessage // DATA_FLAG=5
{
    //0 String any information to display in toastr.info
}