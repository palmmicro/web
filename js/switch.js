function SwitchConfirm(strHint, strLink)
{
    var answer = confirm(strHint);
    if (answer)
    {
        window.location = strLink;
    }
}


