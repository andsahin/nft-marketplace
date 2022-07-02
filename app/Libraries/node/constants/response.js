export const toError = function(res,errors,statusCode=404,){

    if(!errors) {
        errors = 'Something went wrong'
    }

    return res.status(statusCode).send({
        status: "error",
        msg:errors,
    })
}
export const toSuccess = function(res, data = {}, msg = '', statusCode = 200){
    
    if(!msg) {
        msg = 'Data get Successfully'
    }

    return res.status(statusCode).send({
        status: "success",
        msg:msg,
        data:data,
    })
}