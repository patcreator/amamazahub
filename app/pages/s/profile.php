<?php
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../auth/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch basic user data
$stmt = $pdo->prepare("SELECT id, username, email, password, created_at, updated_at, status FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch profile data
$stmt = $pdo->prepare("SELECT id, user_id, first_name, last_name, username, email, phone, avatar_url, bio, gender, date_of_birth, country, city, state, zip_code, social_links, created_at, updated_at FROM user_profile WHERE user_id = ?");
$stmt->execute([$user_id]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission for updating profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update basic info
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $bio = $_POST['bio'];
    $social_links = $_POST['social_links'];
    $avatar_url = $_POST['avatar_url'];

    // Update password if set
    if (!empty($_POST['password']) && $_POST['password'] === $_POST['repassword']) {
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $password_hash, $user_id);
        $stmt->execute();
    }

    // Update profile table
    $stmt = $conn->prepare("UPDATE user_profile SET first_name=?, last_name=?, phone=?, avatar_url=?, bio=?, social_links=? WHERE user_id=?");
    $stmt->bind_param("ssssssi", $first_name, $last_name, $phone, $avatar_url, $bio, $social_links, $user_id);
    $stmt->execute();

    // Optionally redirect to refresh page
    header("Location: profile.php");
    exit;
}
?>
<style>
  [data-tab-content] {
    display: none;
  }
  [data-tab-content].active {
    display: block;
  }
</style>
<div class="flex-grow mt-9 max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
    <div>
        <h1 class="text-lg font-bold text-red-500 py-4">User Profile</h1>
    </div>

    <!-- Tabs -->
    <div>
        <nav class="flex border-b border-gray-200 dark:border-gray-700" aria-label="Tabs">
            <button class="tab-button text-red-500 border-b-2 border-red-500 px-4 py-2 -mb-px font-semibold focus:outline-none" data-tab-target="profile" type="button" aria-selected="true" role="tab" id="tab-profile" aria-controls="panel-profile">
                Profile
            </button>
            <button class="tab-button text-gray-500 hover:text-red-500 px-4 py-2 border-b-2 border-transparent focus:outline-none" data-tab-target="settings" type="button" role="tab" id="tab-settings" aria-controls="panel-settings">
                Settings
            </button>
            <button class="tab-button text-gray-500 hover:text-red-500 px-4 py-2 border-b-2 border-transparent focus:outline-none" data-tab-target="activity" type="button" role="tab" id="tab-activity" aria-controls="panel-activity">
                Activity
            </button>
        </nav>

        <!-- Tab Panels -->
        <section id="panel-profile" role="tabpanel" aria-labelledby="tab-profile" data-tab-content class="active mt-6">
    <h2 class="text-xl font-semibold mb-4 text-red-500">Profile Information</h2>

    <!-- Avatar Preview with Change Button -->
<div class="flex items-center mb-6 relative">
    <img id="avatarPreview" src="<?= $img?>"
         alt="Avatar" class="w-20 h-20 rounded-full border mr-4 cursor-pointer" />

    <!-- Hidden file input -->
    <input type="file" id="avatarFile" name="avatar_file" accept="image/*" class="hidden" />

    <!-- Change Button -->
    <button type="button" id="changeAvatarBtn"
        class="bg-gray-200 hover:bg-gray-300 text-sm text-gray-700 px-3 py-1 rounded-md">
        Change
    </button>

    <!-- Confirm Button (hidden by default) -->
    <button type="button" id="confirmAvatarBtn"
        class="hidden absolute left-20 top-0 bg-gray-500 hover:bg-gray-600 text-white p-2 rounded-full shadow">
        <i class="mdi mdi-check"></i>
    </button>
</div>
<script>
    $(function () {
    // Trigger file input when avatar or button clicked
    $("#avatarPreview, #changeAvatarBtn").on("click", function () {
        $("#avatarFile").click();
    });

    // Preview the selected image
    $("#avatarFile").on("change", function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $("#avatarPreview").attr("src", e.target.result);
                $("#confirmAvatarBtn").removeClass("hidden"); // Show confirm button
            };
            reader.readAsDataURL(file);
        }
    });

    // Confirm avatar upload
    $("#confirmAvatarBtn").on("click", function () {
        const formData = new FormData();
        const file = $("#avatarFile")[0].files[0];
        if (!file) return;

        formData.append("avatar_file", file);
        formData.append("user_id", "<?= $user_id ?>");

        $.ajax({
            url: "<?=$path?>app/system/api/upload_avatar.php", // you need this endpoint
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // alert(response);
                try {
                    const res = JSON.parse(response);
                    if (res.status === "success") {
                        // $("#avatarPreview").attr("src", res.avatar_url);
                        $("#confirmAvatarBtn").addClass("hidden");
                        $("#profileMessage").text("Avatar updated successfully!")
                            .removeClass("text-red-500").addClass("text-green-600");
                    } else {
                        $("#profileMessage").text(res.message || "Upload failed")
                            .removeClass("text-green-600").addClass("text-red-500");
                    }
                } catch (err) {
                    $("#profileMessage").text("Unexpected error.").addClass("text-red-500");
                }
            },
            error: function (xhr) {
                $("#profileMessage").text("Upload error!").addClass("text-red-500");
            }
        });
    });
});

</script>

    <!-- Profile Form -->
    <form id="profileForm" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div>
            <label class="block dark:text-gray-300 text-gray-700 font-medium mb-1" for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" 
                   class="w-full border border-gray-300 rounded-md px-3 py-2 dark:bg-gray-700 dark:border-gray-700"
                   value="<?= htmlspecialchars($profile['first_name']??'') ?>" />
        </div>
        <div>
            <label class="block dark:text-gray-300 text-gray-700 font-medium mb-1" for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" 
                   class="w-full border border-gray-300 rounded-md px-3 py-2 dark:bg-gray-700 dark:border-gray-700"
                   value="<?= htmlspecialchars($profile['last_name']??'') ?>" />
        </div>
        <div>
            <label class="block dark:text-gray-300 text-gray-700 font-medium mb-1" for="phone">Phone</label>
            <input type="tel" name="phone" id="phone" 
                   class="w-full border border-gray-300 rounded-md px-3 py-2 dark:bg-gray-700 dark:border-gray-700"
                   value="<?= htmlspecialchars($profile['phone']??'') ?>" />
        </div>
        <div>
            <label class="block dark:text-gray-300 text-gray-700 font-medium mb-1" for="avatar_url">Avatar URL</label>
            <input type="text" name="avatar_url" id="avatar_url" 
                   class="w-full border border-gray-300 rounded-md px-3 py-2 dark:bg-gray-700 dark:border-gray-700"
                   value="<?= htmlspecialchars($profile['avatar_url']??'') ?>" />
        </div>
        <div class="sm:col-span-2">
            <label class="block dark:text-gray-300 text-gray-700 font-medium mb-1" for="bio">Bio</label>
            <textarea name="bio" id="bio" class="w-full border border-gray-300 rounded-md px-3 py-2 dark:bg-gray-700 dark:border-gray-700"><?= htmlspecialchars($profile['bio']??'') ?></textarea>
        </div>
        <div class="sm:col-span-2">
            <label class="block dark:text-gray-300 text-gray-700 font-medium mb-1" for="social_links">Social Links (JSON)</label>
            <textarea name="social_links" id="social_links" class="w-full border border-gray-300 rounded-md px-3 py-2 dark:bg-gray-700 dark:border-gray-700"><?= htmlspecialchars($profile['social_links']??'') ?></textarea>
        </div>
        <div class="sm:col-span-2">
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-2 rounded-md transition">
                Update Profile
            </button>
        </div>
    </form>
    <div id="profileMessage" class="mt-3 text-sm"></div>
</section>

<section id="panel-settings" role="tabpanel" aria-labelledby="tab-settings" data-tab-content class="mt-6">
    <h2 class="text-xl font-semibold mb-4 text-red-500">Account Settings</h2>
    <form id="settingsForm" class="space-y-6 max-w-lg">
        <div>
            <label class="block dark:text-gray-300 text-gray-700 font-medium mb-1" for="username">Username</label>
            <input type="text" name="username" id="username"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 dark:bg-gray-700 dark:border-gray-700"
                   value="<?= htmlspecialchars($user['username']) ?>" />
        </div>
        <div>
            <label class="block dark:text-gray-300 text-gray-700 font-medium mb-1" for="email">Email</label>
            <input type="email" name="email" id="email"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 dark:bg-gray-700 dark:border-gray-700"
                   value="<?= htmlspecialchars($user['email']) ?>" />
        </div>
        <div>
            <label class="block dark:text-gray-300 text-gray-700 font-medium mb-1" for="password">New Password</label>
            <input type="password" name="password" id="password"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 dark:bg-gray-700 dark:border-gray-700"
                   placeholder="••••••••" />
        </div>
        <div>
            <label class="block dark:text-gray-300 text-gray-700 font-medium mb-1" for="repassword">Re-enter Password</label>
            <input type="password" name="repassword" id="repassword"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 dark:bg-gray-700 dark:border-gray-700"
                   placeholder="••••••••" />
        </div>
        <div>
            <button type="submit"
                class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-2 rounded-md transition">
                Update Account
            </button>
        </div>
    </form>
    <div id="settingsMessage" class="mt-3 text-sm"></div>
</section>

<section id="panel-activity" role="tabpanel" aria-labelledby="tab-activity" data-tab-content class="mt-6">
    <h2 class="text-xl font-semibold mb-4 text-red-500">Recent Activity</h2>

    <div id="activityContainer" class="overflow-x-auto border rounded-md">
        <table class="min-w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-2">Type</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">IP Address</th>
                    <th class="px-4 py-2">Date</th>
                </tr>
            </thead>
            <tbody id="activityTableBody">
                <tr>
                    <td colspan="4" class="px-4 py-3 text-center text-gray-500">Loading activities...</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>








    </div>
</div>

<script>
    // Tab functionality
    const tabButtons = document.querySelectorAll(".tab-button");
    const tabContents = document.querySelectorAll("[data-tab-content]");

    tabButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const target = button.getAttribute("data-tab-target");

            tabButtons.forEach((btn) => {
                btn.classList.remove("border-red-500", "text-red-500", "font-semibold");
                btn.classList.add("border-transparent", "text-gray-500");
                btn.setAttribute("aria-selected", "false");
            });

            tabContents.forEach((content) => {
                content.classList.remove("active");
            });

            button.classList.add("border-red-500", "text-red-500", "font-semibold");
            button.classList.remove("border-transparent", "text-gray-500");
            button.setAttribute("aria-selected", "true");

            const activeContent = document.getElementById(`panel-${target}`);
            if (activeContent) activeContent.classList.add("active");
        });
    });
</script>

<script>
$(function() {
    // Preview avatar when URL is typed
    $("#avatar_url").on("input", function() {
        $("#avatarPreview").attr("src", $(this).val());
    });

    // AJAX form submission
    $("#profileForm").on("submit", function(e) {
        e.preventDefault();

        $.ajax({
            url: "<?=$path?>app/system/api/update_profile.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    $("#profileMessage").text("Profile updated successfully!")
                        .removeClass("text-red-500").addClass("text-green-600");
                    if (response.avatar_url) {
                        $("#avatarPreview").attr("src", response.avatar_url);
                    }
                } else {
                    $("#profileMessage").text(response.message || "Update failed")
                        .removeClass("text-green-600").addClass("text-red-500");
                }
            },
            error: function() {
                $("#profileMessage").text("An error occurred. Please try again.")
                    .removeClass("text-green-600").addClass("text-red-500");
            }
        });
    });
});
</script>
<script>
$(function() {
    $("#settingsForm").on("submit", function(e) {
        e.preventDefault();

        $.ajax({
            url: "<?=$path?>app/system/api/update_settings.php", // endpoint to handle username/email/password updates
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    $("#settingsMessage").text("Account updated successfully!")
                        .removeClass("text-red-500").addClass("text-green-600");
                    $("#password, #repassword").val(""); // clear passwords
                } else {
                    $("#settingsMessage").text(response.message || "Update failed.")
                        .removeClass("text-green-600").addClass("text-red-500");
                }
            },
            error: function() {
                $("#settingsMessage").text("An error occurred. Please try again.")
                    .removeClass("text-green-600").addClass("text-red-500");
            }
        });
    });
});
</script>
<script>
$(function() {
    function loadActivities() {
        $.ajax({
            url: "<?=$path?>app/system/api/get_activity.php",
            type: "GET",
            dataType: "json",
            success: function(response) {
                const tbody = $("#activityTableBody");
                tbody.empty();

                if (response.status === "success" && response.activities.length > 0) {
                    response.activities.forEach((act) => {
                        const row = `
                            <tr class="border-b dark:border-b-0 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-2 font-medium dark:text-gray-300 text-gray-800">${act.activity_type}</td>
                                <td class="px-4 py-2 dark:text-gray-300">${act.description}</td>
                                <td class="px-4 py-2 dark:text-gray-300">${act.ip_address || '-'}</td>
                                <td class="px-4 py-2 text-gray-500 dark:text-red-300">${new Date(act.created_at).toLocaleString()}</td>
                            </tr>`;
                        tbody.append(row);
                    });
                } else {
                    tbody.html(`<tr><td colspan="4" class="px-4 py-3 text-center text-gray-500">No recent activity logs.</td></tr>`);
                }
            },
            error: function(xhr) {
                $("#activityTableBody").html(`<tr><td colspan="4" class="px-4 py-3 text-center text-red-500">Failed to load activities.</td></tr>`);
            }
        });
    }

    // Load activities when the "Activity" tab is clicked
    $("#tab-activity").on("click", loadActivities);
});
</script>
