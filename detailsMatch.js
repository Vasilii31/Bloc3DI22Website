function printMatch()
{
    var printContents = document.getElementById("printable").innerHTML;

    var originalContents = document.body.innerHTML;
    
    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
    //printBtn.style = "display:flex !important;"
}