<?php $__env->startSection('title', __('Complaint Journey')); ?>
<?php $__env->startSection('heading', __('Complaint Journey Designer')); ?>
<?php $__env->startSection('subheading', __('Design the step-by-step journey a complaint takes from submission to final resolution.')); ?>

<?php $__env->startSection('content'); ?>
<div class="grid lg:grid-cols-[400px_1fr] gap-8 items-start" x-data="journeyArchitect()">

    
    <div class="space-y-6">
        <div class="rounded-3xl bg-white border border-slate-200 p-8 shadow-xl shadow-slate-200/40">
            <h3 class="text-[13px] font-black text-slate-900 uppercase tracking-widest mb-6"><?php echo e(__('Journey Builder')); ?>

            </h3>
            <div class="space-y-6">
                <div class="flex gap-4">
                    <div
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-indigo-50 font-black text-indigo-600 ring-1 ring-indigo-500/10 text-[11px]">
                        1</div>
                    <p class="text-[11px] leading-relaxed font-bold text-slate-500 uppercase tracking-tight"><?php echo e(__('Click a status node to select it as the source (highlights in indigo).')); ?></p>
                </div>
                <div class="flex gap-4">
                    <div
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-indigo-50 font-black text-indigo-600 ring-1 ring-indigo-500/10 text-[11px]">
                        2</div>
                    <p class="text-[11px] leading-relaxed font-bold text-slate-500 uppercase tracking-tight"><?php echo e(__('Click a second node to instantly build a pathway between them.')); ?></p>
                </div>
            </div>

            <div x-show="fromId" x-transition.opacity
                class="mt-8 p-4 rounded-2xl bg-indigo-50 border border-indigo-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[9px] font-black uppercase tracking-widest text-indigo-400"><?php echo e(__('Selected
                        Source')); ?></span>
                    <button @click="fromId = ''; updateMermaid()"
                        class="text-[9px] font-black uppercase text-rose-400 hover:text-rose-600 tracking-widest"><?php echo e(__('Cancel')); ?></button>
                </div>
                <p class="text-sm font-black text-indigo-700" x-text="statuses.find(s => s.id == fromId)?.name"></p>
            </div>
        </div>

        <div class="rounded-3xl bg-white border border-slate-200 p-8 shadow-xl shadow-slate-200/40">
            <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
                <h3 class="text-[11px] font-black text-slate-900 uppercase tracking-widest"><?php echo e(__('Complain Journey')); ?>

                </h3>
                <span
                    class="inline-flex h-5 items-center px-2 rounded-full bg-slate-100 text-[10px] font-black text-slate-500"
                    x-text="transitions.length"></span>
                <button @click="resetAll()" x-show="transitions.length > 0"
                    class="text-[10px] font-black uppercase text-rose-500 hover:text-rose-600 tracking-widest underline underline-offset-2"><?php echo e(__('Reset All')); ?></button>
            </div>

            <div class="space-y-2.5 max-h-[350px] overflow-y-auto pr-2 custom-scrollbar">
                <template x-for="(t, index) in transitions" :key="index">
                    <div
                        class="group flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100/50 transition-all hover:bg-white hover:border-slate-200">
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="text-[10px] font-black text-slate-500 truncate" x-text="t.from_name"></span>
                            <svg class="h-3 w-3 shrink-0 text-slate-300" fill="none" stroke="currentColor"
                                stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                            <span class="text-[10px] font-black text-slate-900 truncate" x-text="t.to_name"></span>
                        </div>
                        <button @click="removePath(index)"
                            class="p-1.5 text-slate-300 hover:text-rose-500 transition opacity-0 group-hover:opacity-100">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </template>
            </div>

            <div class="mt-8">
                <form method="POST" action="<?php echo e(route('admin.settings.transitions.sync')); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <template x-for="t in transitions">
                        <input type="hidden" :name="'allow[' + t.from + '][]'" :value="t.to">
                    </template>
                    <button type="submit"
                        class="w-full rounded-2xl bg-indigo-600 text-white py-4 text-xs font-black uppercase tracking-widest hover:bg-slate-900 shadow-2xl shadow-indigo-600/20 transition-all active:scale-95">
                        <?php echo e(__('Save Journey')); ?>

                    </button>
                </form>
            </div>
        </div>
    </div>

    
    <div
        class="rounded-3xl bg-white border border-slate-200 shadow-2xl shadow-slate-200/40 overflow-hidden sticky top-8">
        <div class="px-8 py-6 border-b border-slate-100 bg-white flex items-center justify-between">
            <div class="flex items-center gap-4">
                <span
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-900 text-white shadow-xl shadow-slate-900/10">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                    </svg>
                </span>
                <div>
                    <h2 class="text-sm font-black text-slate-900 uppercase tracking-widest"><?php echo e(__('Visual Journey Map')); ?></h2>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter mt-0.5"><?php echo e(__('Real-time
                        Architect')); ?></p>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-2 text-[10px] font-black uppercase text-slate-400">
                        <span class="h-2.5 w-2.5 rounded-full bg-slate-100 border border-slate-300"></span> <?php echo e(__('Started')); ?>

                    </span>
                    <span class="flex items-center gap-2 text-[10px] font-black uppercase text-slate-400">
                        <span class="h-2.5 w-2.5 rounded-full bg-orange-100 border border-orange-300"></span> <?php echo e(__('Work')); ?>

                    </span>
                    <span class="flex items-center gap-2 text-[10px] font-black uppercase text-slate-400">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-100 border border-emerald-300"></span> <?php echo e(__('Done')); ?>

                    </span>
                </div>
            </div>
        </div>

        <div class="p-10 bg-slate-50/20 min-h-[600px] flex items-center justify-center relative select-none">
            <div id="mermaid-container" class="mermaid w-full"></div>

            <div
                class="absolute bottom-8 left-1/2 -translate-x-1/2 bg-white/80 backdrop-blur-md rounded-2xl border border-slate-200 px-6 py-3 shadow-xl">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em]"><?php echo e(__('Click nodes to draw
                    pathways')); ?></p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.min.js"></script>
<script>
    function journeyArchitect() {
        return {
            transitions: <?php echo \Illuminate\Support\Js::from($statuses -> flatMap(fn($s) => $s -> transitionsFrom -> map(fn($t) => ['from' => $s -> id, 'to' => $t -> to_complaint_status_id, 'from_name' => $s -> alias_name, 'to_name' => $t -> toStatus -> alias_name ?? 'Undefined'])))->toHtml() ?>,
            statuses: <?php echo \Illuminate\Support\Js::from($statuses -> map(fn($s) => ['id' => $s -> id, 'name' => $s -> alias_name, 'state' => $s -> state]))->toHtml() ?>,
            fromId: '',
            toId: '',

            init() {
                setTimeout(() => this.updateMermaid(), 100);
                window.callNodeClick = (id) => this.handleNodeClick(id);
            },

            handleNodeClick(nodeId) {
                let id = nodeId.replace('st', '');
                if (!this.fromId) {
                    this.fromId = id;
                } else if (!this.toId && this.fromId !== id) {
                    this.toId = id;
                    setTimeout(() => this.addPath(), 300);
                } else {
                    this.fromId = (this.fromId == id) ? '' : id;
                    this.toId = '';
                }
                this.updateMermaid();
            },

            addPath() {
                if (!this.fromId || !this.toId) return;

                if (this.transitions.some(t => t.from == this.fromId && t.to == this.toId)) {
                    this.fromId = ''; this.toId = '';
                    this.updateMermaid();
                    return;
                }

                const from = this.statuses.find(s => s.id == this.fromId);
                const to = this.statuses.find(s => s.id == this.toId);

                if (from && to) {
                    this.transitions.push({
                        from: this.fromId,
                        to: this.toId,
                        from_name: from.name,
                        to_name: to.name
                    });
                }

                this.fromId = '';
                this.toId = '';
                this.updateMermaid();
            },

            removePath(index) {
                this.transitions.splice(index, 1);
                this.updateMermaid();
            },

            resetAll() {
                if (confirm('<?php echo e(__('Are you sure you want to clear all connections ? ')); ?>')) {
                    this.transitions = [];
                    this.updateMermaid();
                }
            },

            get mermaidCode() {
                let code = 'flowchart LR\n';

                const groups = {};
                this.statuses.forEach(s => {
                    if (!groups[s.state]) groups[s.state] = [];
                    groups[s.state].push(s);
                });

                const orderedStates = ['Started', 'Processing', 'Resolution'];
                orderedStates.forEach(state => {
                    if (groups[state]) {
                        code += '  subgraph G_' + state + '[\"' + state.toUpperCase() + '\"]\n';
                        groups[state].forEach(s => {
                            const label = s.name.replace(/\"/g, '\'').toUpperCase();
                            let shape = '[\"' + label + '\"]';
                            if (s.id == this.fromId) shape = '([\"' + label + '\"])';
                            if (s.id == this.toId) shape = '([\"' + label + '\"])';
                            code += '    st' + s.id + shape + '\n';
                        });
                        code += '  end\n';
                    }
                });

                this.transitions.forEach((t) => {
                    code += '  st' + t.from + ' --> st' + t.to + '\n';
                });

                if (this.fromId && this.toId) {
                    code += '  st' + this.fromId + ' == Proposal ==> st' + this.toId + '\n';
                }

                this.statuses.forEach(s => {
                    code += '  click st' + s.id + ' callNodeClick\n';
                });

                code += '  classDef started fill:#ffffff,stroke:#94a3b8,color:#475569,stroke-width:2px,font-weight:900\n';
                code += '  classDef processing fill:#fff7ed,stroke:#fb923c,color:#9a3412,stroke-width:2px,font-weight:900\n';
                code += '  classDef resolution fill:#f0fdf4,stroke:#22c55e,color:#14532d,stroke-width:2px,font-weight:900\n';
                code += '  classDef source fill:#4338ca,stroke:#1d4ed8,color:#ffffff,stroke-width:4px\n';
                code += '  classDef destination fill:#059669,stroke:#047857,color:#ffffff,stroke-width:4px\n';

                const stateClasses = { Started: 'started', Processing: 'processing', Resolution: 'resolution' };
                this.statuses.forEach(s => {
                    if (s.id == this.fromId) {
                        code += '  class st' + s.id + ' source\n';
                    } else if (s.id == this.toId) {
                        code += '  class st' + s.id + ' destination\n';
                    } else if (stateClasses[s.state]) {
                        code += '  class st' + s.id + ' ' + stateClasses[s.state] + '\n';
                    }
                });

                return code;
            },

            updateMermaid() {
                const element = document.getElementById('mermaid-container');
                if (!element) return;
                element.removeAttribute('data-processed');
                element.innerHTML = this.mermaidCode;
                mermaid.run({ nodes: [element] });
            }
        };
    }

    mermaid.initialize({
        startOnLoad: false,
        theme: 'base',
        securityLevel: 'loose',
        themeVariables: {
            fontFamily: 'Outfit, sans-serif',
            primaryColor: '#ffffff',
            primaryTextColor: '#334155',
            primaryBorderColor: '#e2e8f0',
            lineColor: '#cbd5e1',
            secondaryColor: '#fef3c7',
            tertiaryColor: '#f0fdf4',
            clusterBkg: '#ffffff',
            clusterBorder: '#f8fafc',
            edgeLabelBackground: '#ffffff'
        },
        flowchart: { curve: 'basis', padding: 24 }
    });
</script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;900&display=swap');

    .mermaid .node {
        cursor: pointer !important;
    }

    .mermaid .node:hover rect,
    .mermaid .node:hover polygon,
    .mermaid .node:hover circle {
        stroke: #6366f1 !important;
        stroke-width: 2px !important;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }

    .mermaid .node text {
        font-family: 'Outfit', sans-serif !important;
        letter-spacing: 0.1em;
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/storage/517/4794517/user/htdocs/resources/views/admin/settings/transitions/index.blade.php ENDPATH**/ ?>