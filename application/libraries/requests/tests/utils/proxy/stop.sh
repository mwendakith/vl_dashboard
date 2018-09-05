<<<<<<< HEAD
PROXYDIR="$PWD/$(dirname $0)"

PIDFILE="$PROXYDIR/proxy.pid"

start-stop-daemon --stop --pidfile $PIDFILE --make-pidfile && rm $PROXYDIR/proxy.pid
=======
PROXYDIR="$PWD/$(dirname $0)"

PIDFILE="$PROXYDIR/proxy.pid"

start-stop-daemon --stop --pidfile $PIDFILE --make-pidfile && rm $PROXYDIR/proxy.pid
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
