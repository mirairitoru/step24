import './bootstrap';
import Alpine from 'alpinejs';
import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.css';

window.Alpine = Alpine;
window.Cropper = Cropper;

Alpine.start();

window.setRole = function(role) {
    
    const roleInput = document.getElementById('role');
    if(!roleInput) return;

    roleInput.value = role;

    const userBtn = document.getElementById('btn-user');
    const orgBtn = document.getElementById('btn-org');

    const userFields = document.getElementById('user-fields');
    const orgFields = document.getElementById('org-fields');

    const form = document.getElementById('registerForm');

    userBtn.classList.remove('bg-green-700', 'text-white');
    orgBtn.classList.remove('bg-green-700', 'text-white');

    if (role === 'organization') {
        userFields.classList.add('hidden');
        orgFields.classList.remove('hidden');
        userBtn.classList.add('bg-gray-200');
        orgBtn.classList.add('bg-green-700', 'text-white');

        // userはdisabled = true無効
        userFields.querySelectorAll('input').forEach(el => {
            el.removeAttribute('name');
        });

        // organizationはdisabled = false有効
        orgFields.querySelectorAll('input').forEach(el => {
            el.setAttribute('name', el.id);
        });

    } else {
        orgFields.classList.add('hidden');
        userFields.classList.remove('hidden');
        orgBtn.classList.add('bg-gray-200');
        userBtn.classList.add('bg-green-700', 'text-white');
        // ここの箇所を編集する
        orgFields.querySelectorAll('input').forEach(el => {
            el.removeAttribute('name');
        });

        userFields.querySelectorAll('input').forEach(el => {
            el.setAttribute('name', el.id);
        });
    }
};

window.switchTab = function(role) {

    const userBtn = document.getElementById('login-btn-user');
    const orgBtn = document.getElementById('login-btn-org');
    const userForm = document.getElementById('userForm');
    const orgForm = document.getElementById('orgForm');

    userBtn.classList.remove('active');
    orgBtn.classList.remove('active');

    if(role === 'org') {
        orgBtn.classList.add('active');
        userForm.classList.add('hidden');
        orgForm.classList.remove('hidden');
    } else {
        userBtn.classList.add('active');
        orgForm.classList.add('hidden');
        userForm.classList.remove('hidden');
    }
};

document.getElementById('login-btn-user').addEventListener('click', () => switchTab('user'));
document.getElementById('login-btn-org').addEventListener('click', () => switchTab('org'));

// ログインのタブ未選択チェック
window.checkLoginTabSelected = function() {
    const userBtn = document.getElementById('login-btn-user');
    const orgBtn = document.getElementById('login-btn-org');

    if(!userBtn.classList.contains('active') && !orgBtn.classList.contains('active')) {
        showPopup("「一般ユーザー」または「保護団体」\nを選択してください");
        document.activeElement.blur();
        return false;
    }
    return true;
};

window.showPopup = function(message) {
    const popup = document.getElementById('popup-message');
    const text = document.getElementById('popup-text');
    const box = document.getElementById('popup-box');

    text.innerHTML = message.replace(/\n/g, "<br>");
    popup.classList.remove('hidden');
    box.classList.remove('opacity-0');
    box.classList.add('opacity-100');

    setTimeout(() => {
        box.classList.remove('opacity-100');
        box.classList.add('opacity-0');
    }, 2000);

    setTimeout(() => {
        popup.classList.add('hidden');
    }, 2500);
}

function setModalImages(images) {

    const container = document.getElementById('modal-carousel');
    const prev = document.getElementById('modal-prev');
    const next = document.getElementById('modal-next');

    container.innerHTML = '';

    const toggleButtons = (show) => {
        [prev, next].forEach(btn => {
            btn.classList.toggle('hidden', !show);
        });
    }

    if (!images || images.length === 0) {
        container.innerHTML = `
            <div class="w-full h-full flex items-center justify-center text-xl">
                画像なし
            </div>
        `;
        toggleButtons(false);
        return;
    }

    // 画像を追加
    images.forEach(src => {
        const img = document.createElement('img');
        img.src = src;
        img.className = "modal-img w-full h-full object-cover hidden";
        container.appendChild(img);
    });

    const items = container.querySelectorAll('.modal-img');
    let index = 0;

    // 最初の画像（TOP画像）を表示
    items[index].classList.remove('hidden');

    //2枚以上だけ矢印有効
    toggleButtons(items.length > 1);

    if(items.length <= 1) return;

    // 次へ
    next.onclick = () => {
        items[index].classList.add('hidden');
        index = (index + 1) % items.length;
        items[index].classList.remove('hidden');
    };

    // 前へ
    prev.onclick = () => {
        items[index].classList.add('hidden');
        index = (index - 1 + items.length) % items.length;
        items[index].classList.remove('hidden');
    };
}

document.addEventListener('DOMContentLoaded', function() {
    const roleInput = document.getElementById('role');

    if(roleInput) {
        window.setRole(roleInput.value);
    }

    document.querySelectorAll('.open-modal').forEach(button => {
        button.addEventListener('click', (e) => {
            // 興味ありボタンをクリックしたらanimal_idが変わる
            const animalId = e.currentTarget.dataset.id;
            
            const title = document.getElementById('modal-title');
            if (title) {
                title.textContent = e.currentTarget.dataset.animal_name || '';
            }

            const form = document.getElementById('favorite-form');
            if(form) {
                form.action = `/favorites/${animalId}`;
            }

            const role = e.currentTarget.dataset.role;
            const isFavorited = e.currentTarget.dataset.favorited === 'true';
            const favoriteBtn = document.getElementById('modal-favorite-btn');

            // if(!favoriteBtn) return;

            // 保護団体は押せない
            if(role === 'organization' || role === 'org') {
                favoriteBtn.textContent = '興味あり(利用不可)';
                favoriteBtn.disabled = true;
                favoriteBtn.classList.remove('bg-blue-600', 'border-blue-600');
                favoriteBtn.classList.add('bg-gray-500','border-gray-500','cursor-not-allowed');
            } else if (isFavorited) {
                // 既に興味あり
                favoriteBtn.textContent = '興味あり済み';
                favoriteBtn.disabled = true;
                favoriteBtn.classList.remove('bg-blue-600', 'border-blue-600');
                favoriteBtn.classList.add('bg-red-500', 'border-red-500' ,'cursor-not-allowed');
            } else {
                favoriteBtn.textContent = '興味あり';
                favoriteBtn.disabled = false;
                favoriteBtn.classList.remove('bg-red-500', 'border-red-500' ,'cursor-not-allowed');
                favoriteBtn.classList.add('bg-blue-600', 'border-blue-600');
            }

            document.querySelectorAll('#modal [data-field]').forEach(el => {
                const key = el.dataset.field;
                el.textContent = e.currentTarget.dataset[key] || '';
            });

            const images = JSON.parse(e.currentTarget.dataset.images || "[]");
            setModalImages(images);
            // 性格のデータ
            const personality = e.currentTarget.dataset.personality || '';
            const container = document.querySelector('[data-field="personality"]');

            if(container) {
                container.innerHTML = '';

                if(personality) {
                    personality.split(',').map(p => p.trim()).forEach(p => {
                        const span = document.createElement('span');
                        span.textContent = p;
                        span.className = "border px-4 py-1 mr-4 inline-block border-black rounded";
                        container.appendChild(span);
                    });
                }
            }

            const modal = document.getElementById('modal');
            if(modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        });
    });

    const closeBtn = document.getElementById('close-modal');
    if(closeBtn) {
        closeBtn.addEventListener('click', function() {
            const modal = document.getElementById('modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');

            const favoriteBtn = document.getElementById('modal-favorite-btn');
            if(!favoriteBtn) {
                favoriteBtn.textContent = '興味あり';
                favoriteBtn.disabled = false;

                favoriteBtn.classList.remove(
                    'bg-red-500' ,'border-red-500', 'cursor-not-allowed',
                    'bg-gray-500', 'border-gray-500'
                );
                favoriteBtn.classList.add('bg-blue-600', 'border-blue-600');
            }
        });
    }

    document.querySelectorAll('.open-user-modal').forEach(button => {
        button.addEventListener('click', (e) => {
            const modal = document.getElementById('user-detail-modal');
            const image = button.dataset.image;
            const modalImage = document.getElementById('modalUserImage');
            const noImage = document.getElementById('modalUserNoImage');

            if(image) {
                modalImage.src = image;
                modalImage.classList.remove('hidden');
                noImage.classList.add('hidden');
            } else {
                modalImage.classList.add('hidden');
                noImage.classList.remove('hidden');
                noImage.textContent= '画像なし';
            }

            modal.querySelectorAll('[data-field]').forEach(el => {
                const key = el.dataset.field;

                el.textContent = e.currentTarget.dataset[key] || '';
            });

            // モダール表示
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    // ユーザー閉じるボタン
    document.getElementById('user-close-modal')
    ?.addEventListener('click', () => {
        const modal = document.getElementById('user-detail-modal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    const matchModal = document.getElementById('match-modal');

    document.getElementById('close-match-modal')
    ?.addEventListener('click', () => {
        matchModal.classList.add('hidden');
        matchModal.classList.remove('flex');
    });

    document.getElementById('later-match-button')
    ?.addEventListener('click', () => {
        matchModal.classList.add('hidden');
        matchModal.classList.remove('flex');
    });

    // ハンバーガーメニュー
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const overlay = document.getElementById('overlay');

    if(menuBtn && mobileMenu && overlay) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.remove('-translate-x-full');
            mobileMenu.classList.add('translate-x-0');
            overlay.classList.remove('hidden');
        });

        overlay.addEventListener('click', () => {
            mobileMenu.classList.add('-translate-x-full');
            mobileMenu.classList.remove('translate-x-0');
            overlay.classList.add('hidden');
        });
    }

    // 通知一覧(表示)
    const openButton = document.getElementById('open-notification-panel');
    const notificationPanel = document.getElementById('notification-panel');
    const notificationOverlay = document.getElementById('notification-overlay');

    if(openButton) {
        openButton.addEventListener('click', function() {
            notificationPanel.classList.remove('translate-x-full');
            notificationOverlay.classList.remove('hidden');
        });
    }

    //　通知一覧(閉じる)
    const closeButton = document.getElementById('close-notification-panel');

    if(closeButton) {
        closeButton.addEventListener('click', function() {
            notificationPanel.classList.add('translate-x-full');
            notificationOverlay.classList.add('hidden');
        });
    }

    // 団体画像アップロード
    let cropper;
    const selectBtn = document.getElementById('selectImage');
    const imageInput = document.getElementById('imageInput');
    const cropModal = document.getElementById('cropModal');
    const cropTarget = document.getElementById('cropTarget');
    const preview = document.getElementById('preview');
    const hiddenInput = document.getElementById('croppedImage');
    const placeholder = document.getElementById('placeholder');

    if(selectBtn && imageInput && preview && cropModal && cropTarget) {
        selectBtn.addEventListener('click', () => {
            imageInput.click();
        });

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if(!file) return;

            // モーダル表示
            cropModal.classList.remove('hidden');
            cropModal.classList.add('flex');

            const imageUrl = URL.createObjectURL(file);

            cropTarget.src = imageUrl;

            cropTarget.onload = () => {
                cropper?.destroy();

                cropper = new Cropper(cropTarget, {
                    aspectRatio:16/9,
                    viewMode:2,
                    autoCropArea:1,
                    movable:true,
                    zoomable:true,
                    scalable:false,
                    dragMode:'move',
                    cropBoxMovable:false,
                    cropBoxResizable:false,
                    background:false,
                });
            }
        });

        // 決定ボタン
        document.getElementById('cropSave')?.addEventListener('click', async() => {
            if(!cropper) return;

            try {

                const canvas = cropper.getCroppedCanvas({
                    width: 3000,
                    height: Math.floor(3000 * 9 / 16),
                });

                const base64 = canvas.toDataURL('image/jpeg',1.0);

                preview.src = base64;
                hiddenInput.value = base64;
                imageInput.value = "";

                preview.classList.remove(
                    'hidden'
                );

                placeholder?.classList.add(
                    'hidden'
                );

                cropModal.classList.add(
                    'hidden'
                );

                cropModal.classList.remove(
                    'flex'
                );

                cropper.destroy();
                cropper = null;

            } catch (e) {
                console.error(e);
            }
        });

        //　キャンセル
        document.getElementById('cropCancel')?.addEventListener('click', () => {
            cropModal.classList.add(
                'hidden'
            );

            cropModal.classList.remove(
                'flex'
            );

            cropTarget.src = '';

            cropper?.destroy();

            cropper = null;
        });
    }

    // ユーザーモーダル
    let userCropper;
    const userInput = document.getElementById('userImageInput');
    const userModal = document.getElementById('userCropModal');
    const userTarget = document.getElementById('userCropTarget');
    const userHidden = document.getElementById('userImage');
    const userPlaceholder = document.getElementById('userPlaceholder');
    const deleteImage = document.getElementById('deleteUserImage');
    const existing = document.getElementById('existingUserImage');

    window.userImage = existing?.value ?? '';

    window.renderUserPreview = function() {
        userPlaceholder.innerHTML = '';

        if(!window.userImage) {
            userPlaceholder.innerHTML = `
            <span class="text-gray-300 text-center">画像アップロード</sapn>`;
            return;
        }

        const wrap = document.createElement('div');
        wrap.className = 'w-full h-full relative';

        // 画像
        const img = document.createElement('img');
        img.src = window.userImage;

        img.className = 'w-full h-full object-cover';
        wrap.appendChild(img);

        const del = document.createElement('button');

        del.type = 'button';
        del.textContent = '✕';
        del.className = `absolute top-2 right-2 w-7 h-7 rounded-full bg-black/60 text-white flex items-center justify-center`;

        del.onclick = () => {
            window.userImage = '';
            userHidden.value = '';
            deleteImage.value = '1';
            renderUserPreview();
        };

        wrap.appendChild(del);
        // 表示
        userPlaceholder.appendChild(wrap);
    }

    if(userPlaceholder) {
        renderUserPreview();
    }

    if(userInput && userModal && userTarget) {
        userInput.addEventListener('change', function() {
            const file = this.files[0];

            if(!file) return;
            userModal.classList.remove(
                'hidden'
            );

            userModal.classList.add(
                'flex'
            );

            const imageUrl = URL.createObjectURL(file);

            userTarget.src = imageUrl;

            userTarget.onload = () => {
                userCropper?.destroy();

                userCropper = new Cropper(userTarget, {
                    aspectRatio:16/9,
                    movable:true,
                    dragMode:'move',
                    zoomable:true,
                    scalable:false,
                    cropBoxMovable: false, 
                    cropBoxResizable:false,
                    autoCropArea:1,
                    background:false,
                    viewMode:2,
                });
            }
        });

        // 決定ボタン
        document.getElementById('userCropSave')?.addEventListener('click', () => {
            if(!userCropper) return;
            try{
                const canvas = userCropper.getCroppedCanvas({
                    width: 3000,
                    height: 3000,
                });

                const base64 = canvas.toDataURL('image/jpeg', 1.0);

                window.userImage = base64;

                userHidden.value = base64;

                deleteImage.value = '0';

                if(userPlaceholder) {
                    renderUserPreview();
                }

                // モーダル閉じる
                userModal.classList.add(
                    'hidden'
                );

                userModal.classList.remove(
                    'flex'
                );

                // 解散
                userCropper.destroy();

                userCropper = null;
            } catch(e) {
                console.error(e);
            }
        });

        // キャンセル
        document.getElementById('userCropCancel')?.addEventListener('click', () => {
            userModal.classList.add(
                'hidden'
            );

            userModal.classList.remove(
                'flex'
            );

            userTarget.src = '';

            userCropper?.destroy();

            userCropper = null;
        });
    }

    // 動物モーダル
    let animalCropper;

    const animalInput = document.getElementById('animalImageInput');
    const animalModal = document.getElementById('animalCropModal');
    const animalTarget = document.getElementById('animalCropTarget');
    const animalHidden = document.getElementById('animalImages');
    const animalPlaceholder = document.getElementById('animalPlaceholder');
    const animalDelete = document.getElementById('deletedImages');

    window.animalImages = [];

    if(animalHidden && animalHidden.value) {
        try {
            const parsed = JSON.parse(animalHidden.value);
            if(Array.isArray(parsed)) {
                window.animalImages = parsed;
            }
        } catch(e) {
            console.log("JSON parse error:", e);
        }
    }

    window.renderPreviews = function() {
        animalPlaceholder.innerHTML = '';
        // 画像がない → 新規登録時の初期表示
        if (window.animalImages.length === 0) {
            animalPlaceholder.innerHTML = `
                <span class="text-gray-300 text-center">画像アップロード</span>
            `;
            return;
        }

        const leftBox = document.createElement('div');
        const rightBox = document.createElement('div');

        leftBox.className = "w-1/2 h-full overflow-hidden relative";
        rightBox.className = "w-1/2 h-full overflow-hidden relative";

        // 2枚まで表示
        if(window.animalImages[0]) {
            const img1 = document.createElement('img');
            img1.src = window.animalImages[0];
            img1.className = "w-full h-full object-cover";
            leftBox.appendChild(img1);

            // 削除ボタン
            const del1 = document.createElement('button');
            del1.textContent = "✕";
            del1.className = "absolute top-1 right-1 bg-black/60 text-white w-7 h-7 rounded-full flex items-center justify-center text-sm font-bold";
            del1.onclick = () => {
                const deleted = JSON.parse(animalDelete.value);
                deleted.push(window.animalImages[0]);
                animalDelete.value = JSON.stringify(deleted);

                window.animalImages.splice(0, 1);
                animalHidden.value = JSON.stringify(window.animalImages);
                renderPreviews();
            }
            leftBox.appendChild(del1);
        }

        if(window.animalImages[1]) {
            const img2 = document.createElement('img');
            img2.src = window.animalImages[1];
            img2.className = "w-full h-full object-cover"
            rightBox.appendChild(img2);

            // 削除ボタン
            const del2 = document.createElement('button');
            del2.textContent = "✕";
            del2.className = "absolute top-1 right-1 bg-black/60 text-white w-7 h-7 rounded-full flex items-center justify-center text-sm font-bold";
            del2.onclick = () => {
                const deleted = JSON.parse(animalDelete.value);
                deleted.push(window.animalImages[1]);
                animalDelete.value = JSON.stringify(deleted);

                window.animalImages.splice(1, 1);
                animalHidden.value = JSON.stringify(window.animalImages);
                renderPreviews();
            }
            rightBox.appendChild(del2);
        }

        // 枠追加
        animalPlaceholder.appendChild(leftBox);
        animalPlaceholder.appendChild(rightBox);

        // 3枚以上
        if(window.animalImages.length > 2) {
            const rest = window.animalImages.length - 2;

            const badge = document.createElement('div');
            badge.className = "absolute bottom-0 right-0 bg-black bg-opacity-60 text-white px-3 py-1 rounded-tl text-lg font-bold";
            badge.textContent = `+${rest}`;

            rightBox.appendChild(badge);
        }
    }

    if(window.animalImages.length > 0) {
        renderPreviews();
    }

    function showLimitPopup() {
        const popup = document.getElementById('limitPopup');
        const box = popup.children[0];

        popup.classList.remove('hidden');

        // フェードイン
        setTimeout(() => {
            box.classList.remove('opacity-0');
        }, 10);

        // 2秒後にフェードアウト
        setTimeout(() => {
            box.classList.add('opacity-0');

            // 完全に消えたら hidden に戻す
            setTimeout(() => {
                popup.classList.add('hidden');
            }, 500);
        }, 2000);
    }

    if(animalInput && animalModal && animalTarget) {
        animalInput.addEventListener('change', function() {
            const file = this.files[0];

            if(!file) return;
            animalModal.classList.remove(
                'hidden'
            );

            animalModal.classList.add(
                'flex'
            );

            const imageUrl = URL.createObjectURL(file);

            animalTarget.src = imageUrl;

            animalTarget.onload = () => {
                animalCropper?.destroy();

                animalCropper = new Cropper(animalTarget, {
                    aspectRatio:16/9,
                    movable:true,
                    dragMode:'move',
                    zoomable:true,
                    scalable:false,
                    cropBoxMovable: false, 
                    cropBoxResizable:false,
                    autoCropArea:1,
                    background:false,
                    viewMode:2,
                });
            }
        });

        // 決定ボタン
        document.getElementById('animalCropSave')?.addEventListener('click', async() => {
            if(!animalCropper) return;

            if(window.animalImages.length >= 5) {
                showLimitPopup();
                return;
            }

            try{
                const canvas = animalCropper.getCroppedCanvas({
                    width: 3000,
                    height: 3000,
                });

                const base64 = canvas.toDataURL('image/jpeg', 1.0);

                window.animalImages.push(base64);

                animalHidden.value = JSON.stringify(window.animalImages);

                renderPreviews();

                // モーダル閉じる
                animalModal.classList.add(
                    'hidden'
                );

                animalModal.classList.remove(
                    'flex'
                );

                // 解散
                animalCropper.destroy();

                animalCropper = null;
            } catch(e) {
                console.error(e);
            }
        });

        // キャンセル
        document.getElementById('animalCropCancel')?.addEventListener('click', () => {
            animalModal.classList.add(
                'hidden'
            );

            animalModal.classList.remove(
                'flex'
            );

            animalTarget.src = '';

            animalCropper?.destroy();

            animalCropper = null;
        });
    }

    // チャット画面のスクロール位置
    const messageArea = document.getElementById('message-area');

    if(!messageArea) return;

    messageArea.scrollTop = messageArea.scrollHeight;
    
});