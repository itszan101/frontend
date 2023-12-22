// base_url = "https://zeus.awh.co.id/netpro/index.php/EpGJHDGGCk8u4in0/";
// base_url = "http://localhost/Adhivasindo/api-net/index.php/EpGJHDGGCk8u4in0/";
// console.log(APP_URL)
"use strict";
const options =
{
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
};
const error = {
    success: false,
    message: 'false'
}
async function post(url, payload) {
    return await axios.post(APP_URL + '/' + url, payload)
        .then((response) => {
            if (response.data.success) {
                return response.data
            }
            else {
                return error;
            }
        }, (er) => {
            return error;
        });
}
async function get(url) {
    return await axios.get(APP_URL + '/' + url)
        .then((response) => {
            if (response.data.success) {
                return response.data
            }
            else {
                return error;
            }
        }, (er) => {
            return error
        });
}
async function update(url, payload) {
    return await axios.update(APP_URL + '/update/' + url, payload)
        .then((response) => {
            if (response.data.success) {
                return response.data
            }
            else {
                return error;
            }
        }, (er) => {
            return error
        });
}
async function del(url) {
    return await axios.delete(APP_URL + '/' + url)
        .then((response) => {
            if (response.data.success) {
                return response.data
            }
            else {
                return error;
            }
        }, (er) => {
            return error
        });
}
