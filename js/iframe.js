

function changeHeight(iframe)
{
          
    if(navigator.userAgent.toLowerCase().indexOf('firefox') > -1)
    {
        var innerDoc = (iframe.contentDocument) ? iframe.contentDocument : iframe.contentWindow.document;
        if (innerDoc.body.offsetHeight) //ns6 syntax
        {
            iframe.height = innerDoc.body.offsetHeight + 32; //Extra height FireFox
        }
       
    }else{
        
        var page_height = iframe.contentWindow.document.body.scrollHeight;
        iframe.height = page_height+50;
        iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 'px';
      
    }
    
    
}