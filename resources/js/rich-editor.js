import { Editor } from "@tiptap/core";
import StarterKit from "@tiptap/starter-kit";
import Link from "@tiptap/extension-link";
import { Placeholder } from "@tiptap/extension-placeholder";

document.addEventListener("DOMContentLoaded", () => {
    const editors = document.querySelectorAll("[data-rich-editor]");

    editors.forEach((element) => {
        const container = element.closest("[x-data]");
        const input = container.querySelector("[data-rich-editor-input]");
        const toolbar = container.querySelector("[data-rich-editor-toolbar]");

        if (!input || !toolbar) {
            return;
        }

        const editor = new Editor({
            element,

            extensions: [
                StarterKit,

                Link.configure({
                    openOnClick: false,
                    autolink: true,
                }),

                Placeholder.configure({
                    placeholder: "Start writing your story...",
                }),
            ],

            content: input.value || "<p></p>",

            onUpdate: ({ editor }) => {
                input.value = editor.getHTML();
            },
        });

        const buttons = toolbar.querySelectorAll("[data-command]");

        buttons.forEach((button) => {
            button.addEventListener("click", () => {
                const command = button.dataset.command;

                switch (command) {
                    case "bold":
                        editor.chain().focus().toggleBold().run();
                        break;

                    case "italic":
                        editor.chain().focus().toggleItalic().run();
                        break;

                    case "strike":
                        editor.chain().focus().toggleStrike().run();
                        break;

                    case "h1":
                        editor
                            .chain()
                            .focus()
                            .toggleHeading({ level: 1 })
                            .run();
                        break;

                    case "h2":
                        editor
                            .chain()
                            .focus()
                            .toggleHeading({ level: 2 })
                            .run();
                        break;

                    case "h3":
                        editor
                            .chain()
                            .focus()
                            .toggleHeading({ level: 3 })
                            .run();
                        break;

                    case "bulletList":
                        editor.chain().focus().toggleBulletList().run();
                        break;

                    case "orderedList":
                        editor.chain().focus().toggleOrderedList().run();
                        break;

                    case "blockquote":
                        editor.chain().focus().toggleBlockquote().run();
                        break;

                    case "code":
                        editor.chain().focus().toggleCode().run();
                        break;

                    case "codeBlock":
                        editor.chain().focus().toggleCodeBlock().run();
                        break;

                    case "horizontalRule":
                        editor.chain().focus().setHorizontalRule().run();
                        break;

                    case "link": {
                        const currentUrl = editor.getAttributes("link").href;

                        const url = window.prompt(
                            "Enter URL:",
                            currentUrl || "https://",
                        );

                        if (url === null) {
                            return;
                        }

                        if (url === "") {
                            editor.chain().focus().unsetLink().run();
                            return;
                        }

                        editor.chain().focus().setLink({ href: url }).run();

                        break;
                    }

                    case "undo":
                        editor.chain().focus().undo().run();
                        break;

                    case "redo":
                        editor.chain().focus().redo().run();
                        break;
                }

                updateToolbar();
            });
        });

        function updateToolbar() {
            buttons.forEach((button) => {
                const command = button.dataset.command;

                let active = false;

                switch (command) {
                    case "bold":
                        active = editor.isActive("bold");
                        break;

                    case "italic":
                        active = editor.isActive("italic");
                        break;

                    case "strike":
                        active = editor.isActive("strike");
                        break;

                    case "h1":
                        active = editor.isActive("heading", { level: 1 });
                        break;

                    case "h2":
                        active = editor.isActive("heading", { level: 2 });
                        break;

                    case "h3":
                        active = editor.isActive("heading", { level: 3 });
                        break;

                    case "bulletList":
                        active = editor.isActive("bulletList");
                        break;

                    case "orderedList":
                        active = editor.isActive("orderedList");
                        break;

                    case "blockquote":
                        active = editor.isActive("blockquote");
                        break;

                    case "code":
                        active = editor.isActive("code");
                        break;

                    case "codeBlock":
                        active = editor.isActive("codeBlock");
                        break;

                    case "link":
                        active = editor.isActive("link");
                        break;
                }

                button.classList.toggle("is-active", active);
            });

            const undoButton = toolbar.querySelector('[data-command="undo"]');

            const redoButton = toolbar.querySelector('[data-command="redo"]');

            if (undoButton) {
                undoButton.disabled = !editor.can().undo();
            }

            if (redoButton) {
                redoButton.disabled = !editor.can().redo();
            }
        }

        editor.on("selectionUpdate", updateToolbar);
        editor.on("transaction", updateToolbar);

        updateToolbar();
    });
});
