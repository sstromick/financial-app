    var Ziggy = {
        namedRoutes: {"passport.authorizations.authorize":{"uri":"oauth\/authorize","methods":["GET","HEAD"],"domain":null},"passport.authorizations.approve":{"uri":"oauth\/authorize","methods":["POST"],"domain":null},"passport.authorizations.deny":{"uri":"oauth\/authorize","methods":["DELETE"],"domain":null},"passport.token":{"uri":"oauth\/token","methods":["POST"],"domain":null},"passport.tokens.index":{"uri":"oauth\/tokens","methods":["GET","HEAD"],"domain":null},"passport.tokens.destroy":{"uri":"oauth\/tokens\/{token_id}","methods":["DELETE"],"domain":null},"passport.token.refresh":{"uri":"oauth\/token\/refresh","methods":["POST"],"domain":null},"passport.clients.index":{"uri":"oauth\/clients","methods":["GET","HEAD"],"domain":null},"passport.clients.store":{"uri":"oauth\/clients","methods":["POST"],"domain":null},"passport.clients.update":{"uri":"oauth\/clients\/{client_id}","methods":["PUT"],"domain":null},"passport.clients.destroy":{"uri":"oauth\/clients\/{client_id}","methods":["DELETE"],"domain":null},"passport.scopes.index":{"uri":"oauth\/scopes","methods":["GET","HEAD"],"domain":null},"passport.personal.tokens.index":{"uri":"oauth\/personal-access-tokens","methods":["GET","HEAD"],"domain":null},"passport.personal.tokens.store":{"uri":"oauth\/personal-access-tokens","methods":["POST"],"domain":null},"passport.personal.tokens.destroy":{"uri":"oauth\/personal-access-tokens\/{token_id}","methods":["DELETE"],"domain":null},"login":{"uri":"login","methods":["GET","HEAD"],"domain":null},"logout":{"uri":"logout","methods":["POST"],"domain":null},"register":{"uri":"register","methods":["GET","HEAD"],"domain":null},"password.request":{"uri":"password\/reset","methods":["GET","HEAD"],"domain":null},"password.email":{"uri":"password\/email","methods":["POST"],"domain":null},"password.reset":{"uri":"password\/reset\/{token}","methods":["GET","HEAD"],"domain":null},"password.update":{"uri":"password\/reset","methods":["POST"],"domain":null},"password.confirm":{"uri":"password\/confirm","methods":["GET","HEAD"],"domain":null},"home":{"uri":"home","methods":["GET","HEAD"],"domain":null},"testing":{"uri":"testing","methods":["GET","HEAD"],"domain":null},"payment.add":{"uri":"payment\/add","methods":["GET","HEAD"],"domain":null},"payment.store":{"uri":"payment","methods":["POST"],"domain":null},"expense.add":{"uri":"expense\/add","methods":["GET","HEAD"],"domain":null},"expense.store":{"uri":"expense","methods":["POST"],"domain":null},"submission.update":{"uri":"submission\/update","methods":["GET","HEAD"],"domain":null},"submission.partial":{"uri":"partial-submission","methods":["POST"],"domain":null},"submission.store":{"uri":"submission","methods":["POST"],"domain":null},"users.get":{"uri":"users","methods":["GET","HEAD"],"domain":null}},
        baseUrl: 'http://localhost:9999',
        baseProtocol: 'http',
        baseDomain: 'localhost',
        basePort: false,
        defaultParameters: []
    };

    if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
        for (var name in window.Ziggy.namedRoutes) {
            Ziggy.namedRoutes[name] = window.Ziggy.namedRoutes[name];
        }
    }

    export {
        Ziggy
    }
