function convertToRupiah(angka){
  var rupiah = '';   
  angka = parseInt(angka); 
  var angkarev = angka.toString().split('').reverse().join('');
  for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
  return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
}

function convertToAngka(rupiah){
  var nilai = rupiah;
  return parseInt(nilai.toString().replace(/,.*|[^0-9]/g, ''), 10);
  //return nilai.toString().replace('R', '');
}