let fetch_query = (formData, entity, operation) => {
    return fetch(`${ $root }model/script/${ entity }/${ operation }.php`, {
        method: "POST",
        headers: new Headers().append('Accept', 'application/json'),
        body: formData
    }).then(res => {
        // if (entity == "usuario") {
        //     res.text().then(function (text) {
        //         console.log(text);
        //     });
        // }
        return res.json();
    }).then(res => res);
}