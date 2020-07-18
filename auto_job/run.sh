!/bin/bash/
# TODO: need to uncomment 
 sudo rm /var/log/snort/snort.u2*
#echo 'old log deleted'

 php /var/www/skripsi-fix/skripsi/auto_job/first_condition.php
#echo 'first condition running'

sudo snort -q -u snort -g snort -c /etc/snort/snort.conf -i ens160 &
sudo /etc/init.d/snort restart
# #echo 'snort running'

sudo barnyard2 -c /etc/snort/barnyard2.conf -d /var/log/snort -f snort.u2 -w /var/log/snort/barnyard2.waldo &
#echo 'barnyard2 running'

 sudo sudo iptables -t nat -A PREROUTING -p tcp --dport 80 -j REDIRECT --to-port 8061 &
 sudo sudo iptables -t nat -A PREROUTING -p udp --dport 80 -j REDIRECT --to-port 8061 &
#echo 'redirect all IP from port 80 to port 8061'

while true
do
#echo 'job add & remove running'
php /var/www/skripsi-fix/skripsi/auto_job/auto_insert_to_iptables.php
php /var/www/skripsi-fix/skripsi/auto_job/auto_remove_from_iptables.php
php /var/www/skripsi-fix/skripsi/auto_job/alert_telegram.php
sleep 1
done
