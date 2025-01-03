(function() {
    function countJsonKeys(json) {
        if (typeof json !== 'string') {
            console.log('Please enter a valid string');
            return;
        }

        let count = {};
        json.split('').forEach((char) => {
            char = char;
            if (count[char]) {
                count[char]++;
            } else {
                count[char] = 1;
            }
        });
       
     
        let sortedCount = {};
        Object.keys(count)
            .sort((a, b) => a.toLowerCase().localeCompare(b.toLowerCase())) 
            .forEach((key) => {
                sortedCount[key] = count[key]; 
            });
    
        
        return JSON.stringify(sortedCount);
       
    }

    const test = countJsonKeys('Development');
    console.log(test)
})();