"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import Wholesale from "@/pages/Wholesale";

export default function WholesalePage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <Wholesale />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 