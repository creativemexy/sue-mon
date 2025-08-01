"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import Support from "@/pages/Support";

export default function SupportPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <Support />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 