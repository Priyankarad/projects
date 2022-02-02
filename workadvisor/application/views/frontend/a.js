let referenceToOldestKey = ‘’;
if (!referenceToOldestKey) { 

  firebase.database().ref(‘items’)
  .orderByKey()
  .limitToLast(5)
  .once(‘value’)
  .then((snapshot) => {       
    let arrayOfKeys = Object.keys(snapshot.val())
    .sort()
    .reverse();    
    let results = arrayOfKeys
    .map((key) => snapshot.val()[key]);    
    referenceToOldestKey = arrayOfKeys[arrayOfKeys.length-1];
    .catch((error) => { … } );

  } else {

    firebase.database().ref(‘items’)
    .orderByKey()
    .endAt(oldestKeyReference)
    .limitToLast(6)
    .once(‘value’)
    .then((snapshot) => {   
      let arrayOfKeys = Object.keys(snapshot.val())
      .sort()
      .reverse()
      .slice(1);    
      let results = arrayOfKeys
      .map((key) => snapshot.val()[key]);     
      referenceToOldestKey = arrayOfKeys[arrayOfKeys.length-1];     
      .catch((error) => { … } );

    }