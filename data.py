import psutil, requests, json, time, sys

# python3.6
# psutil
# pip3

def dsk():
    prt = psutil.disk_partitions()
    l = []
    df = {}
    i = 0
    for i,e in enumerate(prt):
        di = { prt[i][0] : { 'mountpoint': prt[i][1], 'fstype': prt[i][2], 'opts': prt[i][3]}}
        df = {**df, **di}
        l += [prt[i][0]]
        i += 1
    return (df)

def usage():
    prt = psutil.disk_partitions()
    df = {}
    for i,e in enumerate(prt):
        di = { prt[i][0] : {
        'total': psutil.disk_usage(prt[i][0]).total,
        'used': psutil.disk_usage(prt[i][0]).used,
        'free': psutil.disk_usage(prt[i][0]).free,
        'percent': psutil.disk_usage(prt[i][0]).percent
        }}
        df = {**df, **di}
    return (df)

def conStats():
    con = psutil.net_connections()
    items = []
    it = {}
    iti = {}
    i = 0
    stable = 0
    listen = 0
    closeWait = 0
    timeWait = 0
    none = 0
    for i,e in enumerate(con):
        cond = con[i].status
        if cond == 'ESTABLISHED':
            stable += 1
        elif cond == 'LISTEN':
            listen += 1
        elif cond == 'CLOSE_WAIT':
            closeWait += 1
        elif cond == 'TIME_WAIT':
            timeWait += 1
        else:
            none += 1
        if con[i][4] != ():
            iti = { 'ip': con[i][4][0], 'port': con[i][4][1] }
        iti.update({ 'status': con[i].status, 'pid': con[i].pid })
        it = {**it, **iti}
        items += [it]
        i += 1
    return { 'total': len(con), 'stable': stable, 'listen': listen, 'timeWait': timeWait, 'closeWait': closeWait, 'none': none, 'items': items }

def addrs():
    ad = psutil.net_if_addrs()
    fl = {}
    for e in ad.keys():
        sl = { e : ad[e][0].address }
        fl = {**fl, **sl}
    return (fl)

def temp():
    tmp = psutil.sensors_temperatures()
    t = {}
    for e in tmp.keys():
        items = []
        for j in tmp[e]:
            t2 = { 'label' : j.label, 'current': j.current, 'high': j.high, 'critical': j.critical }
            items += [t2]
        t1 = {e:items}
        t = {**t, **t1}
    return (t)

def fan():
    fn = psutil.sensors_fans()
    f = {}
    if fn == {}:
        return {}
    else:
        for e in fn.keys():
            items = []
            for j in fn[e]:
                f2 = { 'label': j.label, 'current': j.current }
                items += [f2]
            f1 = {e: items}
            f = {**f, **f1}
    return (f)

def syst():
    st = psutil.users()
    s = []
    for e in st:
        s += [e.name]
    return (s)

def pids():
    pd = psutil.pids()
    return (len(pd))

def data():
    url = 'https://erik.cat/api/aleix'
    payload = {
        'TOKEN': sys.argv[1],
        'SERVER': sys.argv[2],
        'DATA': {
            'CPU': {
                'times': {
                    'user': { 'sec' : psutil.cpu_times().user, 'percent' : psutil.cpu_times_percent().user },
                    'system': { 'sec' : psutil.cpu_times().system, 'percent' : psutil.cpu_times_percent().system },
                    'idle': { 'sec' : psutil.cpu_times().idle, 'percent' : psutil.cpu_times_percent().idle },
                    'nice': { 'sec' : psutil.cpu_times().nice, 'percent' : psutil.cpu_times_percent().nice },
                    'iowait': { 'sec' : psutil.cpu_times().iowait, 'percent' : psutil.cpu_times_percent().iowait },
                    'irq': { 'sec' : psutil.cpu_times().irq, 'percent' : psutil.cpu_times_percent().irq },
                    'softirq': { 'sec' : psutil.cpu_times().softirq, 'percent' : psutil.cpu_times_percent().softirq },
                    'steal': { 'sec' : psutil.cpu_times().steal, 'percent' : psutil.cpu_times_percent().steal },
                    'guest': { 'sec' : psutil.cpu_times().guest, 'percent' : psutil.cpu_times_percent().guest },
                    'guest_nice': { 'sec' : psutil.cpu_times().guest_nice, 'percent' : psutil.cpu_times_percent().guest_nice }
                },
                'percentTotal': psutil.cpu_percent(),
                'count': psutil.cpu_count(),
                'stats': {
                    'switches': psutil.cpu_stats().ctx_switches,
                    'interrupts': psutil.cpu_stats().interrupts,
                    'softInterrupts': psutil.cpu_stats().soft_interrupts,
                    'syscalls': psutil.cpu_stats().syscalls
                },
                'freq': {
                    'current': psutil.cpu_freq().current,
                    'min': psutil.cpu_freq().min,
                    'max': psutil.cpu_freq().max
                }
            },
            'MEM': {
                'sys': {
                    'total': psutil.virtual_memory().total,
                    'available': psutil.virtual_memory().available,
                    'percent': psutil.virtual_memory().percent,
                    'used': psutil.virtual_memory().used,
                    'free': psutil.virtual_memory().free,
                    'active': psutil.virtual_memory().active,
                    'inactive': psutil.virtual_memory().inactive,
                    'buffers': psutil.virtual_memory().buffers,
                    'cached': psutil.virtual_memory().cached,
                    'shared': psutil.virtual_memory().shared,
                    'slab': psutil.virtual_memory().slab
                },
                'swap': {
                    'total': psutil.swap_memory().total,
                    'used': psutil.swap_memory().used,
                    'free': psutil.swap_memory().free,
                    'percent': psutil.swap_memory().percent,
                    'sin': psutil.swap_memory().sin,
                    'sout': psutil.swap_memory().sout
                }
            },
            'DISKS': {
                'device': dsk(),
                'usage': usage(),
                'statsIO': {
                    'numReads': psutil.disk_io_counters().read_count,
                    'numWrites': psutil.disk_io_counters().write_count,
                    'bytesRead': psutil.disk_io_counters().read_bytes,
                    'bytesWrite': psutil.disk_io_counters().write_bytes,
                    'readTime': psutil.disk_io_counters().read_time,
                    'writeTime': psutil.disk_io_counters().write_time,
                    'numMergReads': psutil.disk_io_counters().read_merged_count,
                    'numMergWrites': psutil.disk_io_counters().write_merged_count,
                    'busyTime': psutil.disk_io_counters().busy_time
                }
            },
            'NET': {
                'statsIO': {
                    'bytesSent': psutil.net_io_counters().bytes_sent,
                    'bytesRecv': psutil.net_io_counters().bytes_recv,
                    'packetsSent': psutil.net_io_counters().packets_sent,
                    'packetsRecv': psutil.net_io_counters().packets_recv,
                    'errin': psutil.net_io_counters().errin,
                    'errout': psutil.net_io_counters().errout,
                    'dropin': psutil.net_io_counters().dropin,
                    'dropout': psutil.net_io_counters().dropout
                },
                'con': conStats(),
                'addrs': addrs()
            },
            'SENS': {
                'temp': temp(),
                'fan': fan(),
                'bat': {
                    'percent': psutil.sensors_battery().percent,
                    'secLeft': psutil.sensors_battery().secsleft,
                    'powerPlugged': psutil.sensors_battery().power_plugged
                }
            },
            'SYS': syst(),
            'PIDS': pids()
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
        #print (d)
        time.sleep(int(sys.argv[3]))

if __name__ == "__main__":
    main()
