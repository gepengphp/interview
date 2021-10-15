# SLAT

二级地址转换技术，（Second Level Address Translation）。

## What is SLAT？
Second Level Address Translation is a technology introduced in both Intel and AMD flavors of processors. Both companies call their version of the technology different names, Intel’s version is called EPT(Extended Page Tables) and AMD calls theirs RVI (Rapid Virtualization Indexing). Intel introduced Extended Page Tables in its processors that were built on the Nehalem architecture, while AMD only introduced RVI in their third generation of Opteron processors codenamed Barcelona. Hyper-V uses this to perform more VM memory management functions and reduce the overhead of translating guest physical addresses to real physical addresses. By doing this, Hypervisor CPU time is significantly reduced, and more memory is saved for each VM.   

**Google 机翻：** 二级地址转换是 Intel 和 AMD 处理器中引入的一项技术。 两家公司都将他们的技术版本称为不同的名称，英特尔的版本称为 EPT（扩展页表），而 AMD 将他们的版本称为 RVI（快速虚拟化索引）。 英特尔在其基于 Nehalem 架构的处理器中引入了扩展页表，而 AMD 仅在其代号为 Barcelona 的第三代 Opteron 处理器中引入了 RVI。 Hyper-V 使用它来执行更多的 VM 内存管理功能，并减少将来宾物理地址转换为真实物理地址的开销。 通过这样做，Hypervisor CPU 时间显着减少，并且为每个 VM 节省了更多内存。   


