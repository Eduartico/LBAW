
function closeInvite(){
    let doc = document.getElementById('invite-div')
    doc.innerHTML = ''
}


function invite(event_id){
    let doc = document.getElementById('invite-div')

    doc.innerHTML = '<input placeholder="username" type="text"  id="username">\n' +
                    '<button onClick="SendInvite('+ event_id +')">send invite</button>\n'+
                    '<button onclick="closeInvite()">close</button>'


}



function SendInvite(event_id){
    let username = document.getElementById('username').value
    let doc = document.getElementById('invite-div')


    let request = setupAjax('/api/invite')

    request.addEventListener('abort',function (){
        doc += errorBanner('server error')
    })

    request.addEventListener('load',function (){
        let json
        try{
            json = JSON.parse(request.responseText)
        }catch (e){
            doc.innerHTML += errorBanner('server error')
            return
        }


        if (!('success' in json)){
            doc.innerHTML += errorBanner(Object.values(json)[0])
            return;
        }

        doc.innerHTML += successBanner('invite successful')


    })

    request.send(encodeForAjax({'command':'create','id':event_id,'username':username}))

}

function addPoll(){

}

function deleteComment(comment_id){

    let request = setupAjax('/comment/' + comment_id,'DELETE')
    request.addEventListener('error',function (){
        document.getElementById('comment:' + comment_id + 'edit').innerHTML += errorBanner('server error')
    })

    request.addEventListener('load',function (){
        let response
        try{
            response = JSON.parse(request.responseText)
        }catch (e){
            document.getElementById('comment:' + comment_id + 'edit').innerHTML += errorBanner('server error')
        }

        if ('success' in JSON){
            document.getElementById('comment:' + comment_id + ':owner').innerText = '[deleted]'
            document.getElementById('comment:' + comment_id + ':text').innerText = '[deleted]'
        }

        document.getElementById('comment:' + comment_id + 'edit').innerHTML += errorBanner('server error')
    })
    request.send()
}

function editComment(comment_id){
    CheckLogin()

    removeCommentBoxes()

    let doc = document.getElementById('comment:'+ comment_id +':text')

    let text = doc.innerText
    doc.setAttribute('hidden','hidden')

    let a = document.createElement('textarea')
    a.value = text
    a.id = 'comment:'+ comment_id +':text:edit'

    let b = document.createElement('button')
    b.setAttribute('onclick','sendEditedComment('+ comment_id +')')
    b.innerText = 'submit'

    document.getElementById('comment:'+ comment_id +':edit').appendChild(a)
    document.getElementById('comment:'+ comment_id +':edit').appendChild(b)
}

function sendEditedComment(comment_id){
    CheckLogin()

    let a = document.getElementById('comment:'+ comment_id +':text:edit')
    let request = setupAjax('/comment/'+comment_id+'/edit')

    request.addEventListener('error',function (){
        document.getElementById('comment:'+ comment_id +':edit').innerText += errorBanner('server error')
    })

    request.addEventListener('load',function (){
        let response
        try {
            response = JSON.parse(request.responseText)
        }catch (e){
            document.getElementById('comment:'+ comment_id +':edit').innerHTML += errorBanner('server error')
        }

        if ('success' in response){
            document.getElementById('comment:'+ comment_id +':text').innerText = a.value
            removeCommentBoxes()
        }else{
            document.getElementById('comment:'+ comment_id +':edit').innerHTML += errorBanner(Object.values(response)[0])
        }
    })

    request.send(encodeForAjax({'text':a.value}))
}

function comment(post_id,comment_id){
    CheckLogin()
    removeCommentBoxes()

    let div = document.getElementById('post:' + post_id + ':' + (comment_id == null ? '' : ('comment:' + comment_id + ':'))+'reply')
    div.innerHTML = commentBox(post_id,comment_id)
}

function SendComment(post_id, comment_id){
    CheckLogin()

    let divId = 'post:' + post_id + ':' + (comment_id == null ? '': ('comment:' + comment_id + ':'))
    let request = setupAjax('/comment/create')
    let text = document.getElementById(divId + 'text').value

    if (text  === ''){
        document.getElementById(divId + 'reply').innerHTML += errorBanner('empty text')
        return
    }

    request.addEventListener('error',function (){
        document.getElementById(divId + 'reply').innerHTML += errorBanner('server error')
    })

    request.addEventListener('load',function (){
        let json
        try {
            json = JSON.parse(request.responseText)
        }catch (e){
            document.getElementById(divId + 'reply').innerHTML += errorBanner('server error')
            return
        }

        if (!('id' in json)){
            document.getElementById(divId + 'reply').innerHTML += errorBanner( Object.values(json)[0])
            return
        }

        let request2 = setupAjax('/comment/' + json.id)
        request2.addEventListener('error',function (){
            document.getElementById(divId + 'reply').innerHTML += errorBanner('unable to load comment please reload page')
        })
        request2.addEventListener('load',function (){
            let a = document.createElement('div')
            document.getElementById(divId + 'comment-list').prepend(a)
            a.innerHTML = request2.responseText
        })

        request2.send()
    })

    if (comment_id == null)
        request.send(encodeForAjax({'postId':post_id, 'text':text}))
    else
        request.send(encodeForAjax({'commentId':comment_id,'postId':post_id, 'text':text}))

}

async function post(event_id) {
    CheckLogin()

    if ((document.getElementById('new-post-title').value.trim()) === ''){
        document.getElementById('post-error').innerHTML += errorBanner('empty title')
        return
    }

    if ((document.getElementById('new-post-title').value.trim()) === ''){
        document.getElementById('post-error').innerHTML +=errorBanner('post body empty')
        return
    }

    let request = setupAjax(event_id +'/post/create');
    request.addEventListener("load",function (){
        let json
        try {
             json = JSON.parse(request.responseText)
        }catch (e){
            document.getElementById('post-error').innerHTML +=errorBanner('server error')
            return
        }

        if (!('id' in json)){
            document.getElementById('post-error').innerHTML +=errorBanner('server error')
            return
        }

        if (document.getElementById("file").files.length > 0) {
            let formData = new FormData();
            formData.append("file", file.files[0]);

            let xhr = new XMLHttpRequest();
            xhr.open('POST',  '/post/' + json.id + '/upload', false);
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
            xhr.send(formData);
        }


        let postRequest = setupAjax( event_id + '/post/' + json.id)
        postRequest.addEventListener('load',function (){
            let div = document.getElementById('post-listing')
            let a = document.createElement('div')
            div.prepend(a)
            a.innerHTML = postRequest.responseText
        })

        postRequest.send();

    })

    request.send(encodeForAjax({
        'title': document.getElementById('new-post-title').value,
        'text': document.getElementById('new-post-text').value
    }));

}

function attend(id,isPrivate){

    CheckLogin()

    const request = setupAjax('/api/attend')

    request.addEventListener('error',function (){
        console.log("jdng")
        //todo popup saying failed to add attending
    })
    request.addEventListener("load",function (){
        console.log("jdngfdshgbfd")
        //todo change the button color
    })
    request.send(encodeForAjax({"command":"create","is_private":isPrivate,"id":id}))
}

function report(id,type){
    CheckLogin()

    const request = setupAjax('/api/report')

    request.addEventListener('error',function (){
        console.log("jdng")
        //todo popup saying failed to upvote
    })
    request.addEventListener("load",function (){
        console.log("jdngfdshgbfd")
        //todo change the button color
    })
    request.send(encodeForAjax({"command":"create","type":type,"id":id}))
}

function vote(id,ispositive,type){

    CheckLogin();

    let count = document.getElementById(type + ':' + id + ':score')
    let nvote = document.getElementById(type + ':' + id + ':nvote')
    let pvote = document.getElementById(type + ':' + id + ':pvote')
    let command

    if (ispositive){
        if (pvote.classList.contains('voted')){
            pvote.classList.remove('voted')
            command = 'delete'
            count.innerHTML--;
        }else if (nvote.classList.contains('voted')){
            pvote.classList.add('voted')
            nvote.classList.remove('voted')
            command = 'create'
            count.innerHTML = parseInt(count.innerHTML) + 2
        }else{
            pvote.classList.add('voted')
            command = 'create'
            count.innerHTML++
        }
    }else{
        if (nvote.classList.contains('voted')){
            nvote.classList.remove('voted')
            command = 'delete'
            count.innerHTML++;
        }else if (pvote.classList.contains('voted')){
            nvote.classList.add('voted')
            pvote.classList.remove('voted')
            command = 'create'
            count.innerHTML =  parseInt(count.innerHTML) - 2
        }else{
            nvote.classList.add('voted')
            command = 'create'
            count.innerHTML--
        }
    }



    const request = setupAjax('/api/vote')

    request.addEventListener('error',function (){
        console.log("jdng")
        //todo popup saying failed to upvote
    })
    request.addEventListener("load",function (){
        let response
        try {
            response = JSON.parse(request.responseText)

        }catch (e){
            errorBanner('login to upvote')
        }

    })
    request.send(encodeForAjax({"command":command,"type":type,"is_positive":ispositive,"id":id}))
}

function CheckLogin(){
    if (loggedIn) {
        return
    } else {
        window.location.href = '/login';
    }
}

function commentBox (post_id,comment_id){
    return '<textarea id="post:' + post_id + ':' + (comment_id == null ? '': ('comment:' + comment_id + ':')) +'text" maxlength="2048"></textarea>\n' +
        '<button onclick="SendComment('+ post_id + ','+ comment_id +')">submit</button>\n'
}

function errorBanner(error){
    return  '<div class="alert error">\n' +
        '     <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>\n' +
        '     '+error+'\n' +
        '</div>'
}

function successBanner(message) {
    return '<div class="alert success" style="background-color: green;">\n' +
        '     <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>\n' +
        '     '+message+'\n' +
        '</div>';
}

function removeCommentBoxes(){
    document.querySelectorAll('.new-comment').forEach(function (container){
        container.innerHTML = ''
    })
    document.querySelectorAll('.comment-text').forEach(function (container){
        container.removeAttribute('hidden')
    })
    document.querySelectorAll('.comment-edit').forEach(function (container){
        container.innerHTML = ''
    })
}

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}

function setupAjax(url,method = "POST"){
    const request = new XMLHttpRequest()
    request.open(method,url,true)
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    return request
}

async function postData(url,data) {
    return fetch(url, {
        method: 'post',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: encodeForAjax(data)
    })
}
