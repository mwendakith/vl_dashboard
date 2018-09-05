<<<<<<< HEAD
def request(context, flow):
	flow.request.headers["x-requests-proxy"] = "http"

def response(context, flow):
=======
def request(context, flow):
	flow.request.headers["x-requests-proxy"] = "http"

def response(context, flow):
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
	flow.response.headers[b"x-requests-proxied"] = "http"