let skinViewer = new skinview3d.SkinViewer({
    canvas: document.getElementById("skin_container"),
    width: 300,
    height: 400,
});

skinViewer.width = 300;
skinViewer.height = 600;
skinViewer.loadSkin("/api/skin/skin/{{ uuid }}/");
skinViewer.loadCape("/api/skin/cape/{{ uuid }}/");
skinViewer.fov = 70;
skinViewer.zoom = 0.5;
skinViewer.autoRotate = false;
skinViewer.animation = new skinview3d.IdleAnimation();
skinViewer.animation.speed = 0.5;
skinViewer.animation.paused = false;

skinViewer.nameTag = "{{ username }}";

const elytraRadioButton = document.querySelector('input[name="back_equipment"][value="elytra"]');
const capeRadioButton = document.querySelector('input[name="back_equipment"][value="cape"]');

// Add event listeners to the radio buttons
elytraRadioButton.addEventListener("change", handleEquipmentChange);
capeRadioButton.addEventListener("change", handleEquipmentChange);

// Function to handle the change event
function handleEquipmentChange(event) {
const selectedValue = event.target.value;

if (selectedValue === "elytra") {
    // Code to handle elytra selection
    console.log("Elytra selected");
    // Call the skinViewer.loadCape() function or any other relevant actions
    skinViewer.loadCape("/api/skin/cape/{{ uuid }}/", { backEquipment: "elytra" });
} else if (selectedValue === "cape") {
    // Code to handle none (cape) selection
    console.log("None (cape) selected");
    // Remove the elytra but keep the cape
    skinViewer.loadCape("/api/skin/cape/{{ uuid }}/");
}
}