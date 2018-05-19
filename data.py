import psutil, requests, json, time, sys

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
        sl = { e : ad[e][0].address }
        fl = {**fl, **sl}
    return fl

def data():
    url = 'https://erik.cat/api/aleix'
    payload = {
        'token': sys.argv[1],
        'server': sys.argv[2],
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

    r = requests.post(url, json = payload)

    if r.status_code == 200:
        return (r.json()) # 200 is good
    else:
        return ("ERROR: " + + str(r.status_code))

def main():
    while True:
        d = data()
        # print (d)
        time.sleep(60)

if __name__ == "__main__":
    main()
