const search = document.querySelector('.input-group input'),
    table_rows = document.querySelectorAll('tbody tr'),
    table_headings = document.querySelectorAll('thead th');

// 1. Searching for specific data of HTML table
search.addEventListener('input', searchTable);

function searchTable() {
    table_rows.forEach((row, i) => {
        let table_data = row.textContent.toLowerCase(),
            search_data = search.value.toLowerCase();

        row.classList.toggle('hide', table_data.indexOf(search_data) < 0);
        row.style.setProperty('--delay', i / 25 + 's');
    })

    document.querySelectorAll('tbody tr:not(.hide)').forEach((visible_row, i) => {
        visible_row.style.backgroundColor = (i % 2 == 0) ? 'transparent' : '#0000000b';
    });
}

const announcement = document.querySelector('.announcement');

async function present(key) {
    try {
      const response = await fetch('present.php?key=' + key);
      if (response.ok) {
        const data = await response.text();
        console.log('loading');
        announcement.innerHTML = data;
        setTimeout(() => {
            location.reload(true);
            
        }, 2000);

      }
    } catch (error) {
      console.error(error);
    } 
  }
  
async function absent(key) {
    try {
      const response = await fetch('absent.php?key=' + key);
      if (response.ok) {
        const data = await response.text();
        console.log(data);
        announcement.innerHTML = data;
        setTimeout(() => {
            location.reload(true);
            
        }, 2000);
      }
    } catch (error) {
      console.error(error);
    }
  }



  async function resetData() {
    try {
      const response = await fetch('startMonthReet.php');
      if (response.ok) {
        const data = await response.text();
        console.log(data);
        announcement.innerHTML = data;
        setTimeout(() => {
            location.reload(true);
            
        }, 2000);
      }
    } catch (error) {
      console.error(error);
    }
  }

