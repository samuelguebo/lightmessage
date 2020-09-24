/**
 * MIT License
 *
 * UI interactions and calls to API
 * are handled through this file.
 *
 * @summary short description for the file
 * @author Samuel Guebo <@samuelguebo>
 *
 * Created at     : 2020-09-21 01:01:56 
 * Last modified  : 2020-09-21 01:02:39
 */

/**
 * Global variables
 */
let messagesTable = document.getElementById('messages-table')
let sendButton = document.getElementById('sendButton')
let checkAllListener = document.getElementById('check-all')

/**
 * Interact with API to post message
 * and return response
 * @param {Message} message 
 */
const sendMessage = (message) => {

    let formData = new FormData();
    formData.append("data", JSON.stringify(message))
    // console.log(`sending ${JSON.stringify(message)}`)
    let messageIndicator = document.getElementById(`message-${message.id}`)
    messageIndicator.classList.add('sending')
    fetch('/message/send', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            messageIndicator.classList.remove('sending')
            if (data.response === false) {
                messageIndicator.classList.add('failed')
                messageIndicator.querySelector('td:last-child').innerHtml = 'failed <span class="indicator"></span>'
            } else {
                messageIndicator.className = 'delivered'
                messageIndicator.querySelector('td:last-child').innerHtml = 'delivered <span class="indicator"></span>'
            }

        })
        .catch(e => {
            console.log(e)
            messageIndicator.classList.add('failed')
            messageIndicator.querySelector('td:last-child').innerText = 'failed'

        })
}

/**
 * Collecting data from all the table rows
 * that were checked
 */
const getSelectedMessages = () => {
    let selectedMessages = []
    let rows = Object.values(messagesTable.rows)
    if (rows.length > 1) {
        rows = rows.slice(1)

        // Extract and convert to object
        for (let row of rows) {

            // Check whether message was already delivered
            if (Array.from(row.classList).indexOf('delivered') < 0) {

                let id = row.id.replace('message-', '')
                let page = row.cells[1].innerText
                let wiki = row.cells[2].innerText
                let status = row.cells[3].innerText
                let checked = row.cells[0].querySelector('input[type=checkbox]').checked
                let batchId = row.getAttribute('batchid')

                if (isset(page) && isset(wiki) && isset(batchId) && isset(status) && (checked)) {
                    selectedMessages.push(new Message(id, page, wiki, batchId, status))
                }
            }

        }
    }

    return selectedMessages
}

/**
 * Constructor for Message objects
 * that emulate PHP model
 * 
 * @param {*} id 
 * @param {*} page 
 * @param {*} wiki 
 * @param {*} batchId 
 * @param {*} status 
 */
const Message = function (id, page, wiki, batchId, status) {
    this.id = id;
    this.page = page;
    this.wiki = wiki;
    this.batchId = batchId;
    this.status = status;
}

/**
 * Helper function, emulating isset() 
 * @param {*} object 
 */
const isset = (object) => {
    return (typeof object !== 'undefined' && object !== null);
}

const setSendButtonListener = () => {
    if (isset(sendButton)) {
        sendButton.addEventListener('click', async (e) => {
            e.preventDefault();
            let messages = getSelectedMessages();
            for (message of messages) {
                await sendMessage(message)
            }
        })
    }
}

const setCheckAllListener = () => {
    if (isset(checkAllListener)) {
        checkAllListener.addEventListener('click', (e) => {
            let checked = this.checked
            for (checkbox of document.querySelectorAll('input[type=checkbox]')) {
                if (checked) {
                    checkbox.checked = false
                } else {
                    checkbox.checked = true
                }
            }
        })
    }
}

/**
 * Display a notice that fades away
 * after a certain time
 * 
 * @param {*} message 
 * @param {*} duration 
 */
const showNotice = (message, duration = 2000) => {
    let notice = document.createElement('div');
    notice.className = 'notice';
    notice.innerText = message;
    if (Array.from(document.querySelector('body').childNodes).indexOf(notice) > -1) {
        document.querySelector('body').removeChild(notice);
    }
    document.querySelector('body').appendChild(notice);
    notice.style.opacity = 1;
    setTimeout(() => {
        notice.style.opacity = 0;

    }, duration);
};


/**
 * Entry point of the UI interactions
 */
const init = () => {
    setSendButtonListener();
    setCheckAllListener();
}

// Run the show
init();