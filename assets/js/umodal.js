;(function(window){
  const UModal = {
    open(options){
      const opts = Object.assign({
        title: '提示',
        content: '', // string | HTMLElement
        html: '',    // preferred string html
        showClose: true,
        buttons: [
          {text: '确定', type: 'primary', onClick: null}
        ],
        width: null,
        onClose: null,
      }, options||{});

      // overlay
      const overlay = document.createElement('div');
      overlay.className = 'umodal-overlay';

      // modal
      const modal = document.createElement('div');
      modal.className = 'umodal';
      if (opts.width) modal.style.minWidth = opts.width;

      // header
      const header = document.createElement('div');
      header.className = 'umodal-header';
      const title = document.createElement('div');
      title.className = 'umodal-title';
      title.textContent = opts.title || '';
      header.appendChild(title);
      if(opts.showClose){
        const close = document.createElement('button');
        close.className = 'umodal-close';
        close.setAttribute('aria-label','关闭');
        close.innerHTML = '×';
        close.onclick = () => api.close();
        header.appendChild(close);
      }

      // body
      const body = document.createElement('div');
      body.className = 'umodal-body';
      if(opts.html){ body.innerHTML = opts.html; }
      else if(typeof opts.content === 'string'){ body.innerHTML = opts.content; }
      else if(opts.content){ body.appendChild(opts.content); }

      // footer
      const footer = document.createElement('div');
      footer.className = 'umodal-footer';
      (opts.buttons||[]).forEach(btn => {
        const b = document.createElement('button');
        b.className = 'umodal-btn ' + (btn.type||'secondary');
        b.textContent = btn.text || '确定';
        b.onclick = () => { if(btn.onClick) btn.onClick(api); else api.close(); };
        footer.appendChild(b);
      });

      modal.appendChild(header);
      modal.appendChild(body);
      if((opts.buttons||[]).length){ modal.appendChild(footer); }

      document.body.appendChild(overlay);
      document.body.appendChild(modal);

      // reflow for transition
      requestAnimationFrame(() => { overlay.classList.add('show'); modal.classList.add('show'); });

      function destroy(){
        overlay.classList.remove('show');
        modal.classList.remove('show');
        setTimeout(() => { overlay.remove(); modal.remove(); }, 200);
        if(opts.onClose) try{ opts.onClose(); }catch(e){}
      }

      overlay.onclick = destroy;

      const api = { close: destroy, el: modal, overlay };
      return api;
    },

    loading(text){
      const content = document.createElement('div');
      content.className = 'umodal-loading';
      content.innerHTML = `<div class="umodal-spinner"></div><div style="margin-left:10px;color:#4a5568;">${text||'加载中...'}</div>`;
      return this.open({ title: '请稍候', content, buttons: [], showClose: false, width: '360px' });
    },

    alert(message, title){
      return this.open({ title: title||'提示', html: `<div style="color:#334155;">${message}</div>`, buttons: [{text:'确定', type:'primary'}], width:'420px' });
    },

    confirm(message, onOk, onCancel){
      return this.open({ title: '确认操作', html: `<div style="color:#334155;">${message}</div>`, width:'420px', buttons:[
        {text:'取消', type:'secondary', onClick: m=>{ m.close(); if(onCancel) onCancel(); }},
        {text:'确定', type:'primary', onClick: m=>{ if(onOk) onOk(m); }}
      ]});
    }
  };

  window.UModal = UModal;
})(window);


