function gotoNext(id){
    const protocol = location.protocol;
    const domain = location.hostname;
    let port = ''
    if (domain == 'localhost') port = location.port;
    const route = `${protocol}://${domain}:${port}`	
    window.location = 'news?offset=' + id;
}


function getParams(){
    let val = 2
    if (location.search == ""){
        return val;
    }
    const urlParams = new URLSearchParams(location.search);
    for (const [key, value] of urlParams) {
        if (key == "offset"){
            if (value == NaN){
                value = 2
            }
            val = value;
        }
        console.log(val)
        return val;
    }
}


function prev(){
    if (getParams() > 1){
        let prv = parseInt(getParams()) - 1
        return window.location = 'news?offset=' + prv
    }
    return 1;
}

function next(pages){
  
    let nxt = parseInt(getParams()) + 1
    if (parseInt(getParams()) >= pages){
        //this.disabled = true;
        return window.location = 'news?offset=' + pages
    }
    return window.location = 'news?offset=' + nxt
}

function deleteNews(id){
    let obj = new XMLHttpRequest();
    obj.open('GET', 'news_delete/'+id, true)
        obj.send()
    obj.onreadystatechange = function(){
        console.log('sarted')
        if (obj.readyState == 4){
            let res = JSON.parse(obj.responseText);
            if(res.status == 200){
            alert("artcle has been deleted")
            location.reload()
            }else{
                alert('could not delete article');
            }
        }

    }
}