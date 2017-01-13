ag.ns("ag.common");

(function(){
    var
        pathRegex = new RegExp("^(/[a-z]+)+"),

        state = function()
        {
            this.currentState = {};
            this.broker = ag.srv("broker");

            window.addEventListener("hashchange", listen.bind(this, false));
            listen.call(this, true);
        },

        removeTrailingSlash = function(path)
        {
            if (path.charAt(path.length - 1) === "/")
                path = path.substr(0, path.length - 1);

            return path;
        },

        parseState = function(reqPath)
        {
            var
                path = pathRegex.test(reqPath) ? reqPath.match(pathRegex)[0] : "",
                requestString = decodeURIComponent(reqPath.substr(path.length + 1)), // length + 1 because of question mark
                request;

            try {
                request = JSON.parse(requestString);
            }
            catch(err) {
                request = requestString;
            }

            return {
                path : path,
                request : request
            };
        },

        listen = function(isInit)
        {
            var
                state = parseState(location.hash.substr(2)),
                eventName = "ag.state." + (isInit ? "init" : "change");

            this.currentState = state;

            this.broker.pub(eventName, state, this.createHash(state.path, state.request));
        };

    state.prototype.createHash = function(path, request)
    {
        path = removeTrailingSlash(typeof path === "string" ? path : this.currentState.path);

        var
            locPath = "#!" + path,
            requestString,
            hash = "";

        if (path || request)
        {
            if (request instanceof Array || request instanceof Object)
            {
                requestString = JSON.stringify(request);
            }
            else if (request !== undefined)
            {
                requestString = String(request);
            }

            if (path.length || requestString !== undefined)
            {
                hash = locPath + (requestString !== undefined ? "?" + requestString : "");
            }
        }

        return hash;
    };

    state.prototype.getCurrentState = function()
    {
        return this.currentState;
    };

    state.prototype.getCurrentHash = function()
    {
        return this.createHash(this.currentState.path, this.currentState.request);
    };

    state.prototype.switchTo = function(path, request)
    {
        location.hash = this.createHash(path, request);
    };

    state.prototype.update = function(path, request)
    {
        path = path !== null ? removeTrailingSlash(path) : this.currentState.path;

        var
            hash = this.createHash(path, request),
            newState = hash || location.pathname;

        history.replaceState(null, "", newState);
        this.broker.pub("ag.state.update", { path : path, request : request }, hash);
    };

    ag.common.State = state;
    ag.srv("state", new state());
})();
