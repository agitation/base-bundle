ag.ns("ag.common");

(function(){

var Broker = function() { };

Broker.prototype.pub = function(eventName)
{
    var
        subscriptions = this.subscriptions,
        eventArgs = Array.prototype.slice.call(arguments, 1);

    if (subscriptions[eventName])
        subscriptions[eventName].forEach(function(callback){
            callback.apply(null, eventArgs);
        });

    return this;
};

Broker.prototype.sub = function(eventNames, callback)
{
    var subscriptions = this.subscriptions;

    if (typeof eventNames === "string")
        eventNames = eventNames.split(/\s+/);

    eventNames.forEach(function(eventName){
        if (!subscriptions[eventName])
            subscriptions[eventName] = [];

        subscriptions[eventName].push(callback);
    });

    return this;
};

Broker.prototype.count = function(eventName)
{
    return this.subscriptions[eventName] ? this.subscriptions[eventName].length : 0;
};

Broker.prototype.subscriptions = {};

ag.s.broker = new Broker();

})();
