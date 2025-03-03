const video = document.getElementById("video");
const canvas = document.getElementById("canvas");
const ctx = canvas.getContext("2d");
const statusText = document.getElementById("status");

async function setupCamera() {
    const stream = await navigator.mediaDevices.getUserMedia({ video: true });
    video.srcObject = stream;
    return new Promise((resolve) => (video.onloadedmetadata = resolve));
}

async function loadModel() {
    statusText.innerText = "Đang tải mô hình...";
    const model = await cocoSsd.load();
    statusText.innerText = "Mô hình đã sẵn sàng!";
    return model;
}

async function detectObjects(model) {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    async function detect() {
        const predictions = await model.detect(video);
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        predictions.forEach((prediction) => {
            const [x, y, width, height] = prediction.bbox;
            ctx.strokeStyle = "red";
            ctx.lineWidth = 2;
            ctx.strokeRect(x, y, width, height);

            ctx.fillStyle = "red";
            ctx.fillText(`${prediction.class} (${Math.round(prediction.score * 100)}%)`, x, y > 10 ? y - 5 : 10);
        });

        requestAnimationFrame(detect);
    }

    detect();
}

async function main() {
    await setupCamera();
    const model = await loadModel();
    detectObjects(model);
}

main();
