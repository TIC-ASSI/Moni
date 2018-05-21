import psutil, requests, json, time, sys, socket, platform

# python3.6
# psutil
# pip3

def dsk():
    prt = psutil.disk_partitions()
    df = {}
    for i in prt:
        di = { i[0] : {
        'mount_point': i[1],
        'file_system': i[2],
        'total': psutil.disk_usage(i[0]).total,
        'used': psutil.disk_usage(i[0]).used,
        'free': psutil.disk_usage(i[0]).free,
        'percent': psutil.disk_usage(i[0]).percent
        } }
        df = {**df, **di}
    return df

def conStats():
    con = psutil.net_connections()
    stable = 0
    listen = 0
    for i in con:
        cond = i.status
        if cond == 'ESTABLISHED':
            stable += 1
        elif cond == 'LISTEN':
            listen += 1
    return { 'total': len(con), 'stable': stable, 'listen': listen }

def addrs():
    ad = psutil.net_if_addrs()
    fl = {}
    for e in ad.keys():
        for i in ad[e]:
            if i.family == socket.AF_INET:
                sl = { e : i.address }
                fl = {**fl, **sl}
                break
    return fl

def data():
    url = 'http://moni.test/api/data?api_token=' + sys.argv[2]
    payload = {
        'server': sys.argv[1],
        'os': platform.system(),
        'version': platform.release(),
        'platform': platform.platform(),
        'processor': platform.processor(),
        'node': platform.node(),
        'data': {
            'cpu': {
                'cores': psutil.cpu_count(),
                'percent': psutil.cpu_percent(), # Total
                'frequency': psutil.cpu_freq().current,
                'min_frequency': psutil.cpu_freq().min,
                'max_frequency': psutil.cpu_freq().max
            },
            'mem': { # System
                'total': psutil.virtual_memory().total,
                'available': psutil.virtual_memory().available,
                'used': psutil.virtual_memory().used,
                'percent': psutil.virtual_memory().percent,
                'free': psutil.virtual_memory().free,
            },
            'disks': dsk(),
            'net': conStats(),
            'addresses': addrs(),
            'pids': len(psutil.pids())
        }
    }

    r = requests.post(url, json = payload, headers = {'Accept': 'application/json'})

    if r.status_code == 200:
        print (r.json()) # 200 is good
    else:
        try:
            data = r.json()
            print (data)
        except:
            pass
        print ('There was an error with the request.')

def main():
    while True:
        d = data()
        time.sleep(60)

if __name__ == "__main__":
    if len(sys.argv) == 1:
        print('The api_token is missing, please enter the API token as the first parameter')
        sys.exit(0)
    if len(sys.argv) == 2:
        print('The server_name is missing, please enter a server name as a second parameter. It will be created if it did not exist')
        sys.exit(0)
    main()
