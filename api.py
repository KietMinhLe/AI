from flask import Flask, request, jsonify
import cv2
import numpy as np
from ultralytics import YOLO

app = Flask(__name__)
model = YOLO("yolov8n.pt")  # Dùng mô hình YOLOv8 nhỏ để nhận diện nhanh

@app.route("/detect", methods=["POST"])
def detect_objects():
    if "image" not in request.files:
        return jsonify({"error": "Không có ảnh!"})

    file = request.files["image"].read()
    npimg = np.frombuffer(file, np.uint8)
    img = cv2.imdecode(npimg, cv2.IMREAD_COLOR)

    results = model(img)
    detections = []

    for result in results:
        for box in result.boxes:
            x1, y1, x2, y2 = map(int, box.xyxy[0])
            confidence = round(float(box.conf[0]), 2)
            label = result.names[int(box.cls[0])]
            detections.append({"label": label, "confidence": confidence, "box": [x1, y1, x2, y2]})

    return jsonify({"detections": detections})

if __name__ == "__main__":
    app.run(debug=True, host="0.0.0.0", port=5000)
