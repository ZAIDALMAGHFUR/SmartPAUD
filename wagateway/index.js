const { default: makeWASocket, fetchLatestBaileysVersion, useMultiFileAuthState, DisconnectReason } = require('@whiskeysockets/baileys');
const express = require('express');
const bodyParser = require('body-parser');
const qrcode = require('qrcode-terminal');
const multer = require('multer'); // Import multer for handling file uploads
const knex = require('knex')(require('./knexfile'));

const app = express();
app.use(bodyParser.json());

const upload = multer({ dest: 'uploads/' });

const startSock = async () => {
    const { state, saveCreds } = await useMultiFileAuthState('auth_info_multi');

    const sock = makeWASocket({
        auth: state,
        printQRInTerminal: false
    });

    sock.ev.on('creds.update', saveCreds);

    sock.ev.on('connection.update', (update) => {
        const { connection, lastDisconnect, qr } = update;

        if (qr) {
            qrcode.generate(qr, { small: true });
        }

        if (connection === 'close') {
            const shouldReconnect = lastDisconnect?.error?.output?.statusCode !== DisconnectReason.loggedOut;
            if (shouldReconnect) {
                startSock();
            } else {
                console.log("Connection closed. You are logged out.");
            }
        }
        console.log('Connection update:', update);
    });

    // sock.ev.on('messages.upsert', async (messageUpdate) => {
    //     console.log('New message:', messageUpdate);

    //     const message = messageUpdate.messages[0];
    //     if (!message.key.fromMe && message.message) {
    //         const from = message.key.remoteJid;
    //         let textMessage;

    //         if (message.message.conversation) {
    //             textMessage = message.message.conversation;
    //         } else if (message.message.extendedTextMessage && message.message.extendedTextMessage.text) {
    //             textMessage = message.message.extendedTextMessage.text;
    //         } else if (message.message.imageMessage && message.message.imageMessage.caption) {
    //             textMessage = message.message.imageMessage.caption;
    //         }

    //         if (textMessage) {
    //             console.log('Received message:', textMessage);

    //             if (textMessage.toLowerCase() === 'hi') {
    //                 await sock.sendMessage(from, { text: 'Hello! How can I assist you today?' });
    //             } else {
    //                 // Respond with interactive buttons
    //                 const buttons = [
    //                     { buttonId: 'id_bayar', buttonText: { displayText: 'Saya Mau Bayar' }, type: 1 }
    //                 ];
    //                 const buttonMessage = {
    //                     text: `Saya Tidak Paham Dengan Apa Yang Kamu Ucapkan, Tapi saya bisa bantu. Ketik apa keperluan Anda, untuk pesan Anda kami sampaikan ke Owner. Ketik "Saya Mau Bayar" untuk melihat opsi pembayaran. Terimakasih.`,
    //                     buttons: buttons,
    //                     headerType: 1
    //                 };

    //                 await sock.sendMessage(from, buttonMessage);
    //             }
    //         } else if (message.message.buttonsResponseMessage) {
    //             const buttonResponse = message.message.buttonsResponseMessage.selectedButtonId;

    //             if (buttonResponse === 'id_bayar') {
    //                 const paymentOptions = [
    //                     { buttonId: 'id_ovo', buttonText: { displayText: 'OVO' }, type: 1 },
    //                     { buttonId: 'id_jago', buttonText: { displayText: 'BANK JAGO' }, type: 1 },
    //                     { buttonId: 'id_bni', buttonText: { displayText: 'BANK BNI' }, type: 1 }
    //                 ];
    //                 const paymentMessage = {
    //                     text: 'Pilih metode pembayaran:',
    //                     buttons: paymentOptions,
    //                     headerType: 1
    //                 };

    //                 await sock.sendMessage(from, paymentMessage);
    //             }
    //         } else if (message.message.buttonsResponseMessage) {
    //             const buttonResponse = message.message.buttonsResponseMessage.selectedButtonId;

    //             if (buttonResponse === 'id_ovo') {
    //                 await sock.sendMessage(from, { text: 'Cara bayar dengan OVO: [insert steps here]' });
    //             } else if (buttonResponse === 'id_jago') {
    //                 await sock.sendMessage(from, { text: 'Cara bayar dengan BANK JAGO: [insert steps here]' });
    //             } else if (buttonResponse === 'id_bni') {
    //                 await sock.sendMessage(from, { text: 'Cara bayar dengan BANK BNI: [insert steps here]' });
    //             }
    //         } else {
    //             console.log('Received a non-text message or unsupported format.');
    //         }
    //     }
    // });


    // INI KHUSUS UNTUK GRUP SATU DAN PRIBADI
    // sock.ev.on('messages.upsert', async (messageUpdate) => {
    //     console.log('New message:', messageUpdate);

    //     const message = messageUpdate.messages[0];
    //     if (!message.key.fromMe && message.message) {
    //         const from = message.key.remoteJid;

    //         // ID grup yang ingin Anda khususkan
    //         const targetGroupId = '120363147346528108@g.us'; // Ganti dengan ID grup Anda

    //         // Cek apakah pesan berasal dari chat pribadi atau grup tertentu
    //         if (from.endsWith('@s.whatsapp.net') || from === targetGroupId) {
    //             let textMessage;

    //             if (message.message.conversation) {
    //                 textMessage = message.message.conversation;
    //             } else if (message.message.extendedTextMessage && message.message.extendedTextMessage.text) {
    //                 textMessage = message.message.extendedTextMessage.text;
    //             } else if (message.message.imageMessage && message.message.imageMessage.caption) {
    //                 textMessage = message.message.imageMessage.caption;
    //             }

    //             if (textMessage) {
    //                 console.log('Received message:', textMessage);

    //                 // Simpan kondisi jika user mengetik "bicara dengan owner"
    //                 let stopAutoReply = false;

    //                 // Automasi untuk pesan dengan kata kunci tertentu
    //                 if (textMessage.toLowerCase().includes('hallo')) {
    //                     await sock.sendMessage(from, { text: 'Terimakasih telah menghubungi saya, silahkan beritahu apa yang bisa saya bantu?' });
    //                 } else if (textMessage.toLowerCase().includes('id')) {
    //                     await sock.sendMessage(from, { text: 'Ya, ada yang bisa dibantu mas?' });
    //                 } else if (textMessage.toLowerCase().includes('bayar')) {
    //                     const paymentOptions = [
    //                         { buttonId: 'id_dana', buttonText: { displayText: 'DANA' }, type: 1 },
    //                         { buttonId: 'id_jago', buttonText: { displayText: 'BANK JAGO' }, type: 1 },
    //                         { buttonId: 'id_bni', buttonText: { displayText: 'BANK BNI' }, type: 1 },
    //                         { buttonId: 'id_gopay', buttonText: { displayText: 'GOPAY' }, type: 1 }
    //                     ];

    //                     const paymentMessage = {
    //                         text: 'Pembayaran bisa dilakukan melalui:',
    //                         footer: 'Pilih metode pembayaran',
    //                         buttons: paymentOptions,
    //                         headerType: 1
    //                     };

    //                     await sock.sendMessage(from, paymentMessage);                        
    //                 } else if (textMessage.toLowerCase().includes('bicara dengan owner')) {
    //                     // Jika pengguna mengetik "bicara dengan owner"
    //                     await sock.sendMessage(from, { text: 'Anda akan dihubungi oleh owner, silahkan tunggu.' });
    //                     stopAutoReply = true; // Set flag untuk menghentikan auto-reply
    //                 } else {
    //                     // Opsi default
    //                     await sock.sendMessage(from, { text: 'Maaf, saya tidak memahami pesan Anda. Silahkan ketik "bayar" untuk info pembayaran Atau Ketik "bicara dengan owner" Terimakasih.' });
    //                 }

    //                 // Simpan kondisi untuk berhenti mengirim pesan otomatis
    //                 if (stopAutoReply) {
    //                     return; // Hentikan eksekusi jika "bicara dengan owner" terdeteksi
    //                 }
    //             }
    //         }
    //     }
    // });


    // INI KHUSUS UNTUK GRUP AJA DAN INSERT TO DB
    // In-memory store to track conversation states
    const userConversationState = {};

    // Function to get or initialize the user's state
    function getUserState(userId) {
        if (!userConversationState[userId]) {
            userConversationState[userId] = { step: 0 };
        }
        return userConversationState[userId];
    }

    // Function to clear user's state after the conversation is done
    function clearUserState(userId) {
        delete userConversationState[userId];
    }

    sock.ev.on('messages.upsert', async (messageUpdate) => {
        console.log('New message:', messageUpdate);

        const message = messageUpdate.messages[0];
        if (!message.key.fromMe && message.message) {
            const from = message.key.remoteJid;

            // ID grup yang ingin Anda khususkan
            const targetGroupId = '120363147346528108@g.us'; // Ganti dengan ID grup Anda

            // Cek apakah pesan berasal dari grup tertentu
            if (from === targetGroupId) {
                let textMessage;

                if (message.message.conversation) {
                    textMessage = message.message.conversation;
                } else if (message.message.extendedTextMessage && message.message.extendedTextMessage.text) {
                    textMessage = message.message.extendedTextMessage.text;
                } else if (message.message.imageMessage && message.message.imageMessage.caption) {
                    textMessage = message.message.imageMessage.caption;
                }

                if (textMessage) {
                    console.log('Received message:', textMessage);

                    // Get the user's current state
                    const userState = getUserState(from);

                    if (userState.step === 0) {
                        // Step 0: Send the initial greeting
                        await sock.sendMessage(from, { text: 'Ya, Ada yang bisa di Bantu Mas, Pak, Buk?' });
                        userState.step = 1; // Move to the next step
                    } else if (userState.step === 1) {
                        // Step 1: Receive the user's query and prompt for the next message
                        await saveMessageToDatabase({
                            from: from,
                            contactName: message.pushName || 'Unknown',
                            message: textMessage,
                            timestamp: new Date()
                        });
                        await sock.sendMessage(from, { text: 'Silahkan Tinggalkan Pesan Yang Ingin Ada Tanyakan, Kami Akan Teruskan Ke Operator Kami Dan Kami Akan Infokan Kepada Anda Siapa Nama Operator nya.' });
                        userState.step = 2; // Move to the next step
                    } else if (userState.step === 2) {
                        // Step 2: Confirm the user's message and provide the operator's name
                        const operator = await getRandomOperator();
                        await sock.sendMessage(from, {
                            text: `Terimakasih Mas, Pak, Bu,\nBerikut Saya Ulangi Pertanya Mas, Pak, Bu, Sebagai Berikut: "${textMessage}"\nPertanyaaan ini Sudah Tercatat di Database Kami, Dan Mas, Pak, Bu Akan DI Bantu Oleh Operator Kami Yang Bernama ${operator.nama}.`
                        });
                        clearUserState(from); // Clear the state as the conversation is complete
                    }
                }
            }
        }
    });



    async function saveMessageToDatabase(details) {
        try {
            await knex('automationbotwa').insert({
                pertanyaan: details.message,
                no_wa: details.from,
                nama_no_wa: details.contactName,
                created_at: new Date(),
                updated_at: new Date()
            });
            console.log('Message saved successfully');
        } catch (error) {
            console.error('Error saving message to database:', error);
        }
    }

    // Pseudo-code function to get a random operator from the database
    async function getRandomOperator() {
        try {
            const operator = await knex('operatorregister')
                .orderByRaw('RANDOM()')
                .first();
            return operator || { name: 'Operator Name' }; // Replace with default if no operator is found
        } catch (error) {
            console.error('Error fetching random operator:', error);
            return { name: 'Operator Name' }; // Return a fallback value in case of error
        }
    }




    // Route to send a message to a contact or a group
    app.post('/send-message', upload.single('image'), async (req, res) => {
        const { phoneNumber, message, isGroup } = req.body;
        let imagePath;

        try {
            // Get the uploaded file path from multer or image URL from the body
            if (req.file) {
                imagePath = req.file.path; // from multer
                console.log('Uploaded image path:', imagePath);
            } else if (req.body.image) {
                imagePath = req.body.image; // from URL or other source
                console.log('Image URL:', imagePath);
            }

            let recipientJid;

            if (isGroup) {
                recipientJid = phoneNumber + '@g.us';
            } else {
                recipientJid = phoneNumber + '@s.whatsapp.net';
            }

            let sentMsg;

            if (imagePath && typeof imagePath === 'string') {
                console.log('Sending image to:', recipientJid);
                sentMsg = await sock.sendMessage(recipientJid, {
                    image: { url: imagePath },
                    caption: message
                });
            } else if (message) {
                console.log('Sending text message to:', recipientJid);
                sentMsg = await sock.sendMessage(recipientJid, { text: message });
            } else {
                throw new Error('No valid message or image data provided');
            }

            res.status(200).json({ status: 'success', messageId: sentMsg.key.id });
        } catch (error) {
            console.error('Error sending message:', error.message);
            res.status(500).json({ status: 'error', message: 'Failed to send message', error: error.message });
        }
    });

    // Route to fetch all group JIDs
    app.get('/get-groups', async (req, res) => {
        try {
            const groups = await sock.groupFetchAllParticipating();
            const groupList = Object.keys(groups).map(groupId => ({
                id: groupId,
                name: groups[groupId].subject
            }));

            res.status(200).json({ status: 'success', groups: groupList });
        } catch (error) {
            res.status(500).json({ status: 'error', message: 'Failed to fetch groups', error: error.message });
        }
    });

    // Route to send a message to a specific group by JID
    app.post('/send-group-message', async (req, res) => {
        const { groupId, message } = req.body;

        try {
            const sentMsg = await sock.sendMessage(groupId + '@g.us', { text: message });
            res.status(200).json({ status: 'success', messageId: sentMsg.key.id });
        } catch (error) {
            res.status(500).json({ status: 'error', message: 'Failed to send message', error: error.message });
        }
    });
};

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`WhatsApp Gateway is running on port ${PORT}`);
    startSock();
});
